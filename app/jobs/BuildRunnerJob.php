<?php 

	use \Github\Client as GithubClient;
	use PHPCheckstyle\PHPCheckstyle;
	use Symfony\Component\Yaml\Parser as YamlParser;
	
	class BuildRunnerJob {
		public function fire($job, $data) {
			$Client = new GithubClient;
			$Client->authenticate(getenv('ANORAK_GITHUB_TOKEN'), NULL, GithubClient::AUTH_HTTP_TOKEN);

			// Gives us the variables we sent through originally
			extract($data);

			$pullRequest = new PullRequest($Payload, $Client);
			$Files = $pullRequest->pullRequestFiles();
			if(count($Files) === 0) continue;

			try {
				$ymlParser = new YamlParser();
				$tmpBuildConfig = $ymlParser->parse($pullRequest->config());
			}catch(Exception $e) {
				// Something went wrong, let's just stop
				$job->delete();
				return FALSE;
			}

			// If we have a key for "standards" then we should use this, then merge our changes on top.
			if(isset($tmpBuildConfig['standards'])) {
				$standard = $tmpBuildConfig['standards'];
				if(in_array(Config::get('standards'), $standard)) {
					$baseBuildConfig = $ymlParser->parse(file_get_contents(app_path() . '/rules/' . $standard . '.yml'));
					$buildConfig = array_merge_recursive($baseBuildConfig, $tmpBuildConfig);
				}else{
					// TODO: Send an email explaining that standards are incorrect.
					$job->delete();
					return FALSE;
				}
			}else{
				$buildConfig = $tmpBuildConfig;
			}

			foreach($Files as $File) {
				$filename = $File->filename();

				if(stristr($filename, '.blade.php')) continue;
				$Extension = pathinfo($filename)['extension'];
				if($Extension !== 'php') continue;

				// Don't run on removed files.
				if($File->removed()) continue;

				$tmpFileName = storage_path() . '/files/' . $File->sha() . '.cs.php';
				file_put_contents($tmpFileName, $File->content());
				$style = new PHPCheckstyle(array('array'), NULL, $buildConfig, NULL, FALSE, FALSE);
				$style->processFiles(array($tmpFileName), array());
				$violations = $style->_reporter->reporters[0]->outputFile[$tmpFileName];
				unlink($tmpFileName);

				// The file is 100% great! Don't do anything.
				if(count($violations) === 0) continue;

				foreach($violations as $lineNumber => $violation) {
					$Msg = join("<br>", array_pluck($violation, 'message'));

					// If the violated line number is not in our patch, don't do anything.
					$violationLine = $File->modifiedLines()->filter(function($Line) use ($lineNumber) {
						return $Line['lineNumber'] == $lineNumber;
					});

					if($violationLine->isEmpty()) continue;

					// Store the violation.
					$build = new Build;
					$build->violations = $Msg;
					$build->repo_id = $Repo['id'];
					$build->save();

					$pullRequest->addComment([
						'messages' => array_pluck($violation, 'message'),
						'filename' => $filename,
						'line'     => $violationLine->first()
					]);
				}
			}

			$job->delete();
		}
	}