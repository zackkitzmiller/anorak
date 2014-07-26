<?php 

	use \Github;

	class RepoSynchronizationJob {
		public function fire($job, $data) {
			$Client= new GitHub\Client();
			$Client->authenticate($_ENV['GITHUB_CLIENT_ID'], $data['github_token']);

			$CurrentUserAPI = $Client->api('current_user');
			$Paginator      = new Github\ResultPager($Client);
			$Repos          = $Paginator->fetchAll($CurrentUserAPI, 'repositories');

			foreach($Repos as $aRepo) {
				Repo::firstOrCreate(array(
					'github_id'        => $aRepo['id'],
					'full_github_name' => $aRepo['full_name'],
					'private'          => $aRepo['private'] == 1 ? 1 : 0
				));
			}

			$job->delete();
		}
	}