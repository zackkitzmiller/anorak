<?php 

	use Illuminate\Database\Eloquent\Collection;
	use \Github;

	class PullRequest {
		const CONFIG_FILE = '.anorak.yml';

		protected $Payload;
		protected $GithubToken;
		protected $Client;

		public function __construct($Payload, $GithubToken) {
			$this->Payload = new Collection($Payload);
			$this->GithubToken = $GithubToken;
		}

		public function headIncludes($Line) {
			// head_commit_files.detect { |file| file.modified_lines.include?(line) }
		}

		public function comments() {
			list($Username, $RepoName) = $this->fullRepoName();
			return $this->Client->api('pull_request')->comments()->all($Username, $RepoName, $this->number());			
		}

		public function pullRequestFiles() {
			dd($this->Payload->get('pull_request'));
			$this->Client->api('pull_request')->files();
		}

		public function addComment($Violation) {
			list($Username, $RepoName) = $this->fullRepoName();
			return $this->Client->api('pull_request')->comments()->create($Username, $RepoName, $this->number(), array(
				'pull_request_number' => $this->number()
				'comment'             => join('<br>', $Violation['messages']),
				'commit'              => $this->headCommit(),
				'filename'            => $Violation['filename'],
				'position'            => $Violation['line']['patch_position']
			));
		}

		public function config() {
			return $this->headCommit()->fileContent(self::CONFIG_FILE);
		}

		public function opened() {
			return $this->Payload->get('action') === 'opened';
		}

		public function synchronize() {
			return $this->Payload->get('action') === 'synchronize';
		}

		private function api() {
			if($this->Client) return $this->Client;
			$Client = new GitHub\Client();
			return $Client->authenticate(getenv('GITHUB_CLIENT_ID'), getenv('ANORAK_GITHUB_TOKEN'));
		}

		private function headCommitFiles() {
			return $this->Payload->get('head_commit')['files'];
		}

		private function buildCommitFile($File) {
			return new CommitFile($File, $this->headCommit());
		}

		private function number() {
			return $this->Payload->get('number');
		}

		private function fullRepoName() {
			return $this->Payload->get('repo');
		}

		private function headCommit() {
			return new Commit($this->fullRepoName(), $this->Payload->get('head.sha'));
		}
	}