<?php 

	use Illuminate\Database\Eloquent\Collection;

	class PullRequest {
		protected $Payload;
		protected $Client;

		public function __construct($Payload, $Client) {
			$this->Payload = new Collection($Payload);
			$this->Client = $Client;
		}

		public function headIncludes($Line) {

		}

		public function comments() {
			// Use GitHub API to return comments on this pull request.
		}

		public function pullRequestFiles() {
			dd($this->Payload->get('pull_request'));
			$this->Client->api('pull_request')->files();
		}

		public function addComment($Violation) {
			// Add the comment
		}

		public function config() {

		}

		public function opened() {
			return $this->Payload->get('action') === 'opened';
		}

		public function synchronize() {
			return $this->Payload->get('action') === 'synchronize';
		}

		public function headCommitFiles() {
			return $this->Payload->get('head_commit')['files'];
		}

		public function buildCommitFile($File) {
			return new CommitFile($File, $this->headCommit());
		}

		public function number() {
			return $this->Payload->get('number');
		}

		public function fullRepoName() {
			return $this->Payload->get('repo');
		}

		public function headCommit() {
			return new Commit($this->fullRepoName(), $this->Payload->get('head.sha'));
		}
	}