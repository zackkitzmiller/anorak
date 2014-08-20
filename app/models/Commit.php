<?php 

	use Illuminate\Database\Eloquent\Collection;

	class Commit extends Collection {
		protected $repoName;
		protected $SHA;

		public function __construct($RepoName = NULL, $Sha = NULL) {
			die('HELLO');
		}

		public function files() {
			// Need to return with buildCommitFile collection
		}

		public function fileContent($FileName) {
			// Return file content.
		}

		private function buildCommitFile($File) {
			return new CommitFile($File)
		}

		private function githubFiles() {

		}
	}