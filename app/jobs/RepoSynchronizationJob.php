<?php 

	use \Github;

	class RepoSynchronizationJob {
		const ORGANIZATION_TYPE = 'Organization';

		public function fire($job, $data) {
			$Client= new GitHub\Client();
			$Client->authenticate(getenv('GITHUB_CLIENT_ID'), $data['github_token']);

			$CurrentUserAPI = $Client->api('current_user');
			$Paginator      = new Github\ResultPager($Client);
			$Repos          = $Paginator->fetchAll($CurrentUserAPI, 'repositories');

			// Clear out existing repositories before syncing.
			if(count($Repos) > 0) {
				try {
					User::find($data['user_id'])->repos->each(function($Repo) {
						$Repo->memberships()->delete();
						$Repo->delete();
					});
				}catch(Exception $e) {
					// Do nothing since there may be no repo's to delete.
				}

				foreach($Repos as $aRepo) {
					$Repo                   = new Repo;
					$Repo->github_id        = $aRepo['id'];
					$Repo->full_github_name = $aRepo['full_name'];
					$Repo->private          = $aRepo['private'] == 1 ? 1 : 0;
					$Repo->in_organization  = $aRepo['owner']['type'] == self::ORGANIZATION_TYPE ? 1 : 0;
					$Repo->save();

					$RepoID = DB::getPdo()->lastInsertId();

					Membership::firstOrCreate(array(
						'repo_id' => $RepoID,
						'user_id' => $data['user_id']
					));
				}
			}

			$job->delete();
		}
	}