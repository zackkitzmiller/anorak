<?php 

	use \Github;

	/**
	 * User Repository Synchronization
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class RepoSynchronizationJob {
		protected $client;

		/**
		 * Executes the job.
		 * Fetches all user and user-org repositories that they are an admin of.
		 *
		 * @return void
		 */
		public function fire($job, $data) {
			$this->client = new GitHub\Client();
			$this->client->authenticate(getenv('GITHUB_CLIENT_ID'), $data['github_token']);

			// Fixes #28
			$repos = array_merge($this->userRepos(), array_values($this->orgRepos()));

			// Clear out existing repositories before syncing.
			if(count($repos) > 0) {
				try {
					User::find($data['user_id'])->repos->each(function($repo) {
						$repo->memberships()->delete();
						$repo->delete();
					});
				}catch(Exception $e) {
					// Do nothing since there may be no repo's to delete.
				}

				foreach($repos as $repo) {
					$githubRepo = Repo::updateOrCreate(array(
						'github_id' => $repo['id'],
					), array(
						'full_github_name' => $repo['full_name'],
						'github_id'        => $repo['id'],
						'private'          => (int)$repo['private'] === 1 ? 1 : 0,
						'in_organization'  => $repo['owner']['type'] == "Organization" ? 1 : 0
					));

					$githubRepo->created(function($repo) use ($data) {
						Membership::firstOrCreate(array(
							'repo_id' => $repo->id,
							'user_id' => $data['user_id']
						));
					});

				}
			}

			$job->delete();
		}

		/**
		 * Fetches the users personal repositories
		 *
		 * @return array
		 */
		private function userRepos() {
			$paginator = new Github\ResultPager($this->client);
			$repos = $paginator->fetchAll($this->client->currentUser(), 'repositories');

			$results = [];
			// Ensure that we have admin access
			foreach($repos as $repo) {
				if($repo['permissions']['admin']) $results[] = $repo;
			}

			return $results;
		}

		/**
		 * Fetches the users organizational repositories
		 *
		 * @return array
		 */
		private function orgRepos() {
			$orgPaginator = new Github\ResultPager($this->client);
			$orgs = $orgPaginator->fetchAll($this->client->currentUser(), 'organizations');

			$results = [];
			foreach($orgs as $org) {
				// Ensure that we have admin access

				$paginator = new Github\ResultPager($this->client);
				$repos = $paginator->fetchAll($this->client->organization(), 'repositories', ['organization' => $org['login']]);

				foreach($repos as $repo) {
					if($repo['permissions']['admin']) $results[] = $repo;
				}
			}

			return $results;
		}
	}