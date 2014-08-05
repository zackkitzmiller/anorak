<?php 

	use \Github\Client as GithubClient;
	use \PHP_CodeSniffer_CLI;

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

			// Get the files changed by the pull request.
			// @TODO: Parse these files and keep the "violations"
			$Files = $this->Client->api('pull_request')->files($User, $RepoName, $Payload['number']);
			foreach($Files as $File) {
				$FileName = $File['filename'];
				$SHA      = $File['sha'];

				$FileContents = $this->Client->api('repos')->contents()->download($User, $RepoName, $FileName, $Payload['pull_request']['head']['ref']);

				$TMPFileName = '/tmp/' . date('U') . sha1($FileName) . '.cs.php';
				file_put_contents($TMPFileName, $FileContents);

				$phpcs    = new PHP_CodeSniffer_CLI;
				$standard = 'PSR1';
				$files    = array($TMPFileName);
				$ignored  = array();

				$options = array(
					'standard'      => array($standard),
					'files'         => $files,
					'ignored'       => $ignored,
					'verbosity'     => 0,
					// 'extensions' => array('php'),
					'restrictions'  => array(
						// 'Generic.Files.LineLength' => 10
					),
					'reportWidth' => 500
				);

				// TODO: Replace this with whatever is used in #19
				ob_start();
				$numErrors = $phpcs->process($options);
				$Errors = ob_get_contents();
				unlink($TMPFileName);
				ob_end_clean();

				$Violations = $this->parseResults($Errors);
				if(count($Violations) === 0) continue;

				foreach($Violations as $LineNo => $Violation) {
					$Msg = join("\n", $Violation);

					// Store the violation.
					$Build = new Build;
					$Build->violations = $Msg;
					$Build->repo_id = $Repo->id;
					$Build->uuid = $Payload['pull_request']['head']['sha'];
					$Build->save();

					$this->Client->api('pull_request')->comments()->create('jbrooksuk', $RepoName, $Payload['number'], array(
						'body'                => $Msg,
						'commit_id'           => $Payload['pull_request']['head']['sha'],
						'path'                => $FileName,
						'position'            => $LineNo
					));
				}
			}

			if($Payload['pull_request']['changed_files'] < getenv('CHANGED_FILES_THRESHOLD')) {
				// Queue::push('SmallBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'high');
			}else{
				// Queue::push('LargeBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'medium');
			}
		}

		public function parseResults($Result) {
			$Results = preg_split('/\n/', $Result);

			// Get rid of the excess
			$Results = array_where($Results, function($key, $value) {
				return (int)$key >= 5 && (int)$key <= 24;
			});

			// Now loop each row, save the line, type and message.
			$Violations = array();
			foreach($Results as $Result) {
				$Violation = explode('|', trim($Result));

				if(empty(trim($Violation[0]))) continue;
				if(!isset($Violation[0], $Violation[1], $Violation[2])) continue;

				$Violations[trim($Violation[0])][] = trim($Violation[2]);
			}

			return $Violations;
		}
	}
