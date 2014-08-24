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

			if(App::environment() === 'local') {
				$Payload = new Payload(json_decode(file_get_contents(storage_path() . '/pullrequest-43.json'), TRUE));
			}else{
				$Payload = new Payload(json_decode(Request::getContent(), TRUE));
			}
			$Event   = Request::header('X-GitHub-Event');

			// It's a test (ping), say hi.
			if($Event === 'ping') return Response::make(['ping' => 'OK']);
			// Only comment when the pull request is opened or synchronized.
			if(!$Payload->relevant()) return Response::make(['success' => FALSE]);

			$PullRequest = new PullRequest($Payload->toArray(), $this->Client);
			$Files = $PullRequest->pullRequestFiles();
			if(count($Files) === 0) continue;

			try {
				$ymlParser = new YamlParser();
				$BuildConfig = $ymlParser->parse($PullRequest->config());
			}catch(Exception $e) {
				// Something went wrong, let's just stop.
				return Response::make(array(
					'error' => TRUE,
					'message' => 'Unable to parse .anorak.yml file'
				));
			}

			foreach($Files as $File) {
				$filename = $File->filename();

				if(stristr($filename, '.blade.php')) continue;
				$Extension = pathinfo($filename)['extension'];
				if($Extension !== 'php') continue;

				dd($File->modifiedLines());

				// Don't run on removed files.
				if($File->removed()) continue;

				// @TODO: - Only comment on the new lines.
				// 		  - Don't comment on the same line twice (on next push)
				$TMPFileName = storage_path() . '/files/' . $File->sha() . '.cs.php';
				file_put_contents($TMPFileName, $File->content());
				$Style = new PHPCheckstyle(array('array'), NULL, $BuildConfig, NULL, FALSE, FALSE);
				$Style->processFiles(array($TMPFileName), array());
				$Violations = $Style->_reporter->reporters[0]->outputFile[$TMPFileName];
				unlink($TMPFileName);

				// dd($Violations);
				// The file is 100% great! Don't do anything.
				if(count($Violations) === 0) continue;

				foreach($Violations as $LineNo => $Violation) {
					$Msg = join("<br>", array_pluck($Violation, 'message'));

					// Store the violation.
					$Build = new Build;
					$Build->violations = $Msg;
					$Build->repo_id = $Repo->id;
					$Build->save();

					// @TODO: Replace this with PullRequest->addComment()
					/*$this->Client->api('pull_request')->comments()->create('jbrooksuk', $RepoName, $Payload->number(), array(
						'body'      => $Msg,
						'commit_id' => $ShaRef,
						'path'      => $filename,
						'position'  => $LineNo
					));*/
					$PullRequest->addComment([
						'messages' => array_get($Violation, 'message'),
						'filename' => $filename,
						'line'     => $LineNo
					]);
				}
			}

			return Response::make(array(
				'errors'  => [],
				'success' => TRUE
			));
		}
	}
