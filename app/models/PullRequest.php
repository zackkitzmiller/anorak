<?php

	use Illuminate\Database\Eloquent\Collection;
	use \Github;

	/**
	 * PullRequest
	 * Allows us to manipulate the actual PullRequest itself.
	 * Some methods wrap certain parts of the PR.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
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
			return $this->api()->pullRequest()->comments()->all($Username, $RepoName, $this->number());
		}

		public function pullRequestFiles() {
			list($Username, $RepoName) = $this->fullRepoName();
			$Files = $this->api()->pullRequest()->files($Username, $RepoName, $this->number());
			return array_map(function($File) {
				return $this->buildCommitFile($File);
			}, $Files);
		}

		public function addComment($Violation) {
			list($Username, $RepoName) = $this->fullRepoName();
			if (!empty($Violation['messages'])) {
				return $this->api()->pullRequest()->comments()->create($Username, $RepoName, $this->number(), array(
					'body'      => join('<br>', $Violation['messages']),
					'commit_id' => $this->Payload->get('pull_request')['head']['sha'],
					'path'      => $Violation['filename'],
					'position'  => $Violation['line']->getPatchPos()
				));
			}
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

		public function number() {
			return $this->Payload->get('number');
		}

		private function api() {
			if($this->Client) return $this->Client;
			$this->Client = new GitHub\Client();
			$this->Client->authenticate(getenv('GITHUB_CLIENT_ID'), getenv('ANORAK_GITHUB_TOKEN'));
			return $this->Client;
		}

		private function headCommitFiles() {
			return $this->Payload->get('head_commit')['files'];
		}

		private function buildCommitFile($File) {
			return new CommitFile($File, $this->headCommit());
		}

		private function fullRepoName() {
			return explode('/', $this->Payload->get('repository')['full_name']);
		}

		private function headCommit() {
			return new Commit($this->fullRepoName(), $this->Payload->get('pull_request')['head']['sha'], $this->api());
		}
	}
