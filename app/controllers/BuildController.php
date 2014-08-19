<?php 

	use \Github\Client as GithubClient;
	use PHPCheckstyle\PHPCheckstyle;
	use Symfony\Component\Yaml\Parser as YamlParser;

	class BuildController extends BaseController {
		protected $Client;

		public function __construct(GithubClient $Client) {
			$this->Client = $Client;
			$this->Client->authenticate(getenv('ANORAK_GITHUB_TOKEN'), NULL, GithubClient::AUTH_HTTP_TOKEN);
		}

		public function build(Repo $Repo) {
			list($User, $RepoName) = explode('/', $Repo->full_github_name);

			$Payload = json_decode(Request::getContent(), TRUE);
			$Event   = Request::header('X-GitHub-Event');

			// It's a test (ping), say hi.
			if($Event === 'ping') {
				return Response::make(array(
					'ping' => 'OK'
				));
			}

			if(!in_array($Payload['action'], array('opened', 'synchronize'))) {
				return Response::make(array(
					'success' => FALSE,
					'sniffed' => FALSE
				));
			}

			// Get the files changed by the pull request.
			// @TODO: Parse these files and keep the "violations"
			$Files = $this->Client->api('pull_request')->files($User, $RepoName, $Payload['number']);
			if(count($Files) === 0) continue;

			try {
				$Config = $this->Client->api('repo')->contents()->download($User, $RepoName, '.anorak.yml');
				$ymlParser = new YamlParser();
				$BuildConfig = $ymlParser->parse($Config);
			}catch(Exception $e) {
				// Something went wrong, let's just stop.
				return Response::make(array(
					'error' => TRUE,
					'message' => 'No .anorak.yml file found in the root of the ' . $User . '/' . $RepoName . ' repository.'
				));
			}

			foreach($Files as $File) {
				$FileName = $File['filename'];

				// Don't run on removed files.
				if($File['status'] === 'removed') continue;

				if(!isset($Payload['pull_request']['head']['ref'])) continue;

				try {
					$FileContents = $this->Client->api('repo')->contents()->download($User, $RepoName, $FileName, $Payload['pull_request']['head']['ref']);
				} catch (Exception $e) {
					/*return Response::make(array(
						'error' => TRUE,
						'message' => 'Something went wrong when fetching "'.$User.'/'.$RepoName.'/'.$FileName.'" contents.'
					));*/
					continue;
				}

				print_r($FileContents);

				$TMPFileName = storage_path() . '/files/' . $File['sha'] . '.cs.php';
				file_put_contents($TMPFileName, $FileContents);

				$Style = new PHPCheckstyle(array('array'), NULL, $BuildConfig, NULL, TRUE, FALSE);
				$Violations = head($Style->processFiles($TMPFileName, array()));

				print_r($Violations); exit;

				if(count($Violations) === 0) continue;

				foreach($Violations as $Violation) {
					// $Msg = join("<br>", $Violation);
					$Msg = $Violation['message'];

					// Store the violation.
					$Build = new Build;
					$Build->violations = $Msg;
					$Build->repo_id = $Repo->id;
					$Build->uuid = $Payload['pull_request']['head']['sha'];
					$Build->save();

					$this->Client->api('pull_request')->comments()->create('jbrooksuk', $RepoName, $Payload['number'], array(
						'body'      => $Msg,
						'commit_id' => $Payload['pull_request']['head']['sha'],
						'path'      => $FileName,
						'position'  => $Violations['line']
					));
				}
			}

			return Response::make(array(
				'success' => TRUE
			));
		}
	}
