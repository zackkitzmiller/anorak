<?php 

	use \Github\Client as GithubClient;
	use \PHP_CodeSniffer_CLI;
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

			if($Payload['action'] !== 'opened' || $Payload['action'] !== 'synchronize') {
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
					return Response::make(array(
						'error' => TRUE,
						'message' => 'Something went wrong when fetching "'.$User.'/'.$RepoName.'/'.$FileName.'" contents.'
					));
				}

				$TMPFileName = storage_path() . '/files/' . $File['sha'] . '.cs.php';
				file_put_contents($TMPFileName, $FileContents);

				$phpcs    = new PHP_CodeSniffer_CLI;
				// $phpcs->reporting = new PHP_CodeSniffer_Reports_Json;
				$standard = array_get($BuildConfig, 'standard', 'PSR2');
				$files    = array($TMPFileName);

				$options = array(
					'standard'      => array($standard),
					'files'         => $TMPFileName,
					'ignored'       => array(),
					'verbosity'     => 1,
					// 'extensions' => array('php'),
					'restrictions'  => array(
						// 'Generic.Files.LineLength' => 10
					),
					'reportWidth' => 1024
				);

				// TODO: Replace this with whatever is used in #19
				ob_start();
				$phpcs->process($options, $standard);
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
						'body'      => $Msg,
						'commit_id' => $Payload['pull_request']['head']['sha'],
						'path'      => $FileName,
						'position'  => $LineNo
					));
				}
			}

			return Response::make(array(
				'success' => TRUE
			));
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
