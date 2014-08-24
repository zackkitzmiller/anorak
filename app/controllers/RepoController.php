<?php 

	use \Github;

	class RepoController extends BaseController {
		public function activate(Repo $Repo) {
			// Only allow activation of repositories if you're a member of it.
			if($Repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
				return Response::make(array(
					'errors' => array(
						'You must be the owner or a collaborator to activate this repository'
					),
					'success' => FALSE
				), 403);
			}

			try {
				// Do stuff to the GitHub side of things.
				$Repo->addAnorakToRepo($Repo->full_github_name);
				$hook = $Repo->addBuildHookToRepo($Repo->full_github_name);

				// Save the hook in the repo table.
				if($Repo->activate($hook['id'])) {
					return Response::make([
						'errors'  => [],
						'success' => TRUE
					]);
				}else{
					return Response::make([
						'errors' => [
							'Repository could not be activated'
						],
						'success' => FALSE
					], 500);
				}
			} catch (Exception $e) {
				return Response::make([
					'errors' => [
						$e->getMessage()
					],
					'success' => FALSE
				], 403);
			}
		}

		public function deactivate(Repo $Repo) {
			// Only allow deactivation of repositories if you're a member of it.
			if($Repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
				return Response::make(array(
					'errors' => array(
						'You must be the owner or a collaborator to deactivate this repository'
					),
					'success' => FALSE
				), 403);
			}

			try {
				// Do stuff to the GitHub side of things.
				$Repo->removeAnorakFromRepo($Repo->full_github_name);
				$Repo->removeBuildHookFromRepo($Repo->full_github_name);

				// Remove the hook_id and deactivate from the repo table.
				if($Repo->deactivate()) {
					// Only allow activation of repositories if you're a member of it.
					if($Repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
						return Response::make(array(
							'errors' => array(),
							'success' => TRUE
						));
					}
				}else{
					// Only allow activation of repositories if you're a member of it.
					if($Repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
						return Response::make(array(
							'errors' => array(
								'Repository could not be deactivated'
							),
							'success' => FALSE
						), 500);
					}
				}
			} catch (Exception $e) {
				return Response::make(array(
					'errors' => array(
						$e->getMessage()
					),
					'success' => FALSE
				), 403);
			}
		}
	}
