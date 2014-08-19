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

			$_Payload = json_decode(Request::getContent(), TRUE);
			$Payload = new Payload($_Payload);
			$Event   = Request::header('X-GitHub-Event');

			// It's a test (ping), say hi.
			if($Event === 'ping') {
				return Response::make(array(
					'ping' => 'OK'
				));
			}

			if(!in_array($Payload->action(), array('opened', 'synchronize'))) {
				return Response::make(array(
					'success' => FALSE,
					'sniffed' => FALSE
				));
			}

			// Get the files changed by the pull request.
			// @TODO: Parse these files and keep the "violations"
			$Files = $this->Client->api('pull_request')->files($User, $RepoName, $Payload->number());
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

			$PullRequest = new PullRequest($_Payload, $this->Client);
			$PullRequest->pullRequestFiles();
			dd('LOL');

			foreach($Files as $_File) {
				$FileName = $_File['filename'];


				// dd();


				if(stristr($FileName, '.blade.php')) continue;
				$Extension = pathinfo($FileName)['extension'];
				if($Extension !== 'php') continue;
				
				// Don't run on removed files.
				if($File->removed()) continue;

				if(!isset($Payload->pullRequest()['head']['ref'])) continue;

				$ShaRef = $Payload->pullRequest()['head']['ref'];

				dd($File->content());

				dd();

				$TMPFileName = storage_path() . '/files/' . $_File['sha'] . '.cs.php';
				file_put_contents($TMPFileName, $FileContents);
				$Style = new PHPCheckstyle(array('array'), NULL, $BuildConfig, NULL, FALSE, FALSE);
				$Style->processFiles(array($TMPFileName), array());
				$Violations = $Style->_reporter->reporters[0]->outputFile[$TMPFileName];
				unlink($TMPFileName);

				if(count($Violations) === 0) continue;

				foreach($Violations as $LineNo => $Violation) {
					$Msg = join("<br>", array_pluck($Violation, 'message'));

					// Store the violation.
					$Build = new Build;
					$Build->violations = $Msg;
					$Build->repo_id = $Repo->id;
					$Build->save();

					$this->Client->api('pull_request')->comments()->create('jbrooksuk', $RepoName, $Payload->number(), array(
						'body'      => $Msg,
						'commit_id' => $ShaRef,
						'path'      => $FileName,
						'position'  => $LineNo
					));
				}
			}

			return Response::make(array(
				'success' => TRUE
			));
		}
	}
