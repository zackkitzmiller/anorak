<?php 

	use \Github;

	class RepoController extends BaseController {
		public function activate(Repo $Repo) {
			try {
				// Do stuff to the GitHub side of things.
				$Repo->addAnorakToRepo($Repo->full_github_name);
				$Hook = $Repo->addBuildHookToRepo($Repo->full_github_name);

				// Save the hook in the repo table.
				if($Repo->activate($Hook['id'])) {
					return array(
						'type' => 'success'
					);
				}else{
					return array(
						'type' => 'error'
					);
				}
			} catch (Exception $e) {
				return array(
					'message' => 'Unable to activate repository',
					'type'    => 'error'
				);
			}
		}

		public function deactivate(Repo $Repo) {
			try {
				// Do stuff to the GitHub side of things.
				$Repo->removeAnorakFromRepo($Repo->full_github_name);
				$Repo->removeBuildHookFromRepo($Repo->full_github_name);

				// Remove the hook_id and deactivate from the repo table.
				if($Repo->deactivate()) {
					return array(
						'type' => 'success'
					);
				}else{
					return array(
						'type' => 'error'
					);
				}
			} catch (Exception $e) {
				return array(
					'message' => 'Unable to activate repository',
					'type'    => 'error'
				);
			}
		}
	}
