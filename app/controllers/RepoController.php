<?php 

	use \Github;

	class RepoController extends BaseController {
		public function activate(Repo $Repo) {
			try {
				// Do stuff to the GitHub side of things.
				$Repo->addAnorakToRepo($Repo->full_github_name);
				$Hook = $Repo->addBuildHookToRepo($Repo->full_github_name);

				// Save the hook in the repo table.
				$Repo->activate($Hook['id']);
			} catch (Exception $e) {
				throw $e;
			}
		}

		public function deactivate(Repo $Repo) {
			try {
				// Do stuff to the GitHub side of things.
				$Repo->removeAnorakFromRepo($Repo->full_github_name);
				$Repo->removeBuildHookFromRepo($Repo->full_github_name);

				// Remove the hook_id and deactivate from the repo table.
				$Repo->deactivate();
			} catch (Exception $e) {
				throw $e;
			}
		}
	}
