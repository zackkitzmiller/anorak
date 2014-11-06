<?php

	/**
	 * GithubUser
	 * Easy way of interacting with a GitHub user account.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
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
			$Teams = $this->Client->user()->teams();
			dd($Teams);
		}
	}
