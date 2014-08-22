<?php 

	class Commit {
		protected $repoName;
		protected $SHA;
		protected $Client;

		public function __construct($repoName, $sha, $Client) {
			$this->repoName = $RepoName;
			$this->SHA      = $sha;
			$this->Client   = $Client;
		}

		public function files() {
			// Need to return with buildCommitFile collection
		}

		public function fileContent($FileName) {
			list($Username, $RepoName) = $this->repoName;
			$Contents = $this->Client->repo()->contents()->download($Username, $RepoName, $this->SHA);
			if(!is_null($Contents)) {
				return base64_decode($Contents);
			}else{
				return FALSE;
			}
		}

		private function buildCommitFile($File) {
			return new CommitFile($File, $this);
		}

		/*private function githubFiles() {
			return $this->Client->
		}*/
	}