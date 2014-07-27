<?php 

	namespace Anorak\RepoActivator;

	use \Github;

	class RepoActivator {
		protected $Client;

		public function __construct(Github $Client) {
			$this->Client = $Client;
		}

		public function activate($Repo, $GithubToken) {

		}

		public function deactivate($Repo, $GithubToken) {

		}

		public function createWebHook($Repo) {

		}

		public function buildsUrl() {

		}
	}