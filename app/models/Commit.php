<?php 

	/**
	 * Commit
	 * Handles storing of a commit from within a PullRequest model.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Commit {
		protected $repoName;
		protected $SHA;
		protected $Client;

		public function __construct($repoName, $sha, $Client) {
			$this->repoName = $repoName;
			$this->SHA      = $sha;
			$this->Client   = $Client;
		}

		public function files() {
			// Need to return with buildCommitFile collection
			return array_map(function($File) {
				return $this->buildCommitFile($File);
			}, $this->githubFiles());
		}

		public function fileContent($FileName) {
			list($Username, $RepoName) = $this->repoName;
			$Contents = $this->Client->repo()->contents()->download($Username, $RepoName, $FileName, $this->SHA);
			if(!is_null($Contents)) {
				return $Contents;
			}else{
				return FALSE;
			}
		}

		private function buildCommitFile($File) {
			return new CommitFile($File, $this);
		}

		private function githubFiles() {
			list($Username, $RepoName) = explode($this->repoName);
			return $this->Client->commit()->show($Username, $RepoName, $this->SHA);
		}
	}