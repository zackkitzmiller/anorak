<?php 

	class GithubUser {
		protected $Client;

		public function __construct(GithubClient $Client) {
			$this->Client = $Client;
			$this->Client->authenticate(getenv('ANORAK_GITHUB_TOKEN'), NULL, GithubClient::AUTH_HTTP_TOKEN);
		}

		public function hasAdminAccessThroughTeam($TeamID) {
			// return $this->adminTeams()-
		}

		public function adminTeams() {
			$Teams = $this->Client->api('user')->teams();
			dd($Teams);
		}
	}