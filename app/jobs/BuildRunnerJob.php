<?php

	use \Github\Client as GithubClient;
	use PHPCheckstyle\PHPCheckstyle;
	use Symfony\Component\Yaml\Parser as YamlParser;

	/**
	 * When the /build/{id} route is requested, we kick off this job.
	 * This is what does all of the work.
	 */
	class BuildRunnerJob {
		/**
		 * Execute the job.
		 *
		 * @return void
		 */
		public function fire($job, $data) {
			$client = new GithubClient;
			$client->authenticate(getenv('ANORAK_GITHUB_TOKEN'), null, GithubClient::AUTH_HTTP_TOKEN);

			// Gives us the variables we sent through originally
			extract($data);]

			$pullRequest = new PullRequest($payload, $client);
			$files = $pullRequest->pullRequestFiles();
			// No files to modify.
			if (empty($files)) {
				return false;
			}

			try {
				$ymlParser = new YamlParser();
				$tmpBuildConfig = $ymlParser->parse($pullRequest->config());
			} catch(Exception $e) {
				// Something went wrong, let's just stop
				$job->delete();
				return false;
			}

			// If we have a key for "standards" then we should use this, then merge our changes on top.
			if (isset($tmpBuildConfig['standards'])) {
				$standard = $tmpBuildConfig['standards'];
				if (in_array(Config::get('standards'), $standard)) {
					$baseBuildConfig = $ymlParser->parse(file_get_contents(app_path() . '/rules/' . $standard . '.yml'));
					$buildConfig = array_merge_recursive($baseBuildConfig, $tmpBuildConfig);
				}else{
					// TODO: Send an email explaining that standards are incorrect.
					$job->delete();
					return false;
				}
			}else{
				$buildConfig = $tmpBuildConfig;
			}

			foreach ($files as $file) {
				$startTime = microtime(true);

				$filename = $file->filename();
				$extension = pathinfo($filename)['extension'];
				if (stristr($filename, '.blade.php') || $extension !== 'php' || $file->removed()) {
					continue;
				}

				$tmpFileName = storage_path() . '/files/' . basename($filename);
				file_put_contents($tmpFileName, $file->content());
				// TODO: Replace this with Hippo (#92)
				$style = new PHPCheckstyle(array('array'), null, $buildConfig, null, false, false);
				$style->processFiles(array($tmpFileName), array());
				$violations = $style->_reporter->reporters[0]->outputFile[$tmpFileName];
				unlink($tmpFileName);

				// The file is 100% great! Don't do anything.
				if ($violations === null || count($violations) === 0) {
					continue;
				}

				foreach ($violations as $violation) {
					foreach ($violation as $violater) {
						$violationMsg = $violater['message'];
						$lineNumber = $violater['line'];

						// If the violated line number is not in our patch, don't do anything.
						$violationLine = $file->modifiedLines()->filter(function($line) use ($lineNumber) {
							return (int)$line['patchPosition'] === (int)$lineNumber;
						});

						if ($violationLine->isEmpty()) {
							continue;
						}

						// Store the violation.
						$build = new Build;
						$build->violations = $violationMsg;
						$build->repo_id = $repo['id'];
						$build->time_taken = microtime(true) - $startTime;
						$build->save();

						$pullRequest->addComment([
							'messages' => array_pluck($violation, 'message'),
							'filename' => $filename,
							'line'     => $violationLine->first()
						]);
					}
				}
			}

			$job->delete();
		}
	}
