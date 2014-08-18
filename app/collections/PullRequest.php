<?php 

	use Illuminate\Database\Eloquent\Collection;

	class PullRequest extends Collection {
		public function headIncludes($Line) {

		}

		public function comments() {
			// Use GitHub API to return comments on this pull request.
		}

		public function pullRequestFiles() {

		}

		public function addComment($Violation) {
			// Add the comment
		}

		public function config() {

		}

		public function opened() {
			return $this->items['action'] === 'opened';
		}

		public function synchronize() {
			return $this->items['action'] === 'synchronize';
		}

		public function headCommitFiles() {
			return $this->items['head_commit']['files'];
		}

		public function buildCommitFile($File) {
			return new CommitFile($File, $this->items['head_commit']);
		}

		public function number() {
			return $this->items['number'];
		}

		public function fullRepoName() {
			return $this->items['full_repo_name'];
		}

		public function headCommit() {
			// return $this->items['head_commit']
		}
	}