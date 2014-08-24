<?php 

	use \Github\Client as GithubClient;
	use PHPCheckstyle\PHPCheckstyle;
	use Symfony\Component\Yaml\Parser as YamlParser;
	
	class BuildRunnerJob {
		public function fire($Job, $data) {
			$Client = new GithubClient;
			$Client->authenticate(getenv('ANORAK_GITHUB_TOKEN'), NULL, GithubClient::AUTH_HTTP_TOKEN);

			// Gives us the variables we sent through originally
			extract($data);

			$PullRequest = new PullRequest($Payload, $Client);
			$Files = $PullRequest->pullRequestFiles();
			if(count($Files) === 0) continue;

			try {
				$ymlParser = new YamlParser();
				$BuildConfig = $ymlParser->parse($PullRequest->config());
			}catch(Exception $e) {
				// Something went wrong, let's just stop
				$Job->delete();
				return FALSE;
			}

			foreach($Files as $File) {
				$filename = $File->filename();

				if(stristr($filename, '.blade.php')) continue;
				$Extension = pathinfo($filename)['extension'];
				if($Extension !== 'php') continue;

				// Don't run on removed files.
				if($File->removed()) continue;

				$TMPFileName = storage_path() . '/files/' . $File->sha() . '.cs.php';
				file_put_contents($TMPFileName, $File->content());
				$Style = new PHPCheckstyle(array('array'), NULL, $BuildConfig, NULL, FALSE, FALSE);
				$Style->processFiles(array($TMPFileName), array());
				$Violations = $Style->_reporter->reporters[0]->outputFile[$TMPFileName];
				unlink($TMPFileName);

				// The file is 100% great! Don't do anything.
				if(count($Violations) === 0) continue;

				foreach($Violations as $lineNumber => $Violation) {
					$Msg = join("<br>", array_pluck($Violation, 'message'));

					// If the violated line number is not in our patch, don't do anything.
					$violationLine = $File->modifiedLines()->filter(function($Line) use ($lineNumber) {
						return $Line['lineNumber'] == $lineNumber;
					});

					if($violationLine->isEmpty()) continue;

					// Store the violation.
					$Build = new Build;
					$Build->violations = $Msg;
					$Build->repo_id = $Repo->id;
					$Build->save();

					$PullRequest->addComment([
						'messages' => array_pluck($Violation, 'message'),
						'filename' => $filename,
						'line'     => $violationLine->first()
					]);
				}
			}

			$Job->delete();
		}
	}