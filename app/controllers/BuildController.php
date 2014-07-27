<?php 

	use \Github\Client as GithubClient;
	use \PHP_CodeSniffer as Sniffer;

	class BuildController extends BaseController {
		protected $Client;

		public function __construct(GithubClient $Client) {
			$this->Client = $Client;
			$this->Client->authenticate($_ENV['ANORAK_GITHUB_TOKEN'], NULL, GithubClient::AUTH_HTTP_TOKEN);
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

			// Get the files changed by the pull request.
			// @TODO: Parse these files and keep the "violations"
			$Files = $this->Client->api('pull_request')->files($User, $RepoName, $Payload['number']);
			foreach($Files as $File) {
				$FileName = $File['filename'];
				$SHA      = $File['sha'];

				$FileContents = $this->Client->api('repos')->contents()->download($User, $RepoName, $FileName, $Payload['pull_request']['head']['ref']);

				$TMPFileName = '/tmp/' . date('U') . sha1($FileName) . '.cs.php';
				file_put_contents($TMPFileName, $FileContents);

				$Sniff = new Sniffer;
				$Results = $Sniff->process($TMPFileName, 'Generic');
				dd($Results);

				try {

					$this->Client->api('pull_request')->comments()->create('jbrooksuk', $RepoName, $Payload['number'], array(
						// 'pull_request_number' => $Payload['number'],
						'body'                => 'Testing replying on a commit from Anorak!',
						'commit_id'           => $Payload['pull_request']['head']['sha'],
						'path'                => $FileName,
						'position'            => 4
					));
				} catch (Exception $e) {
					Log::error($e);
				}
			}


			if($Payload['pull_request']['changed_files'] < $_ENV['CHANGED_FILES_THRESHOLD']) {
				// Queue::push('SmallBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'high');
			}else{
				// Queue::push('LargeBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'medium');
			}
		}
	}
