<?php 

	use \Github;

	class RepoController extends BaseController {
		public function activate(Repo $Repo) {
			try {
				$Repo->addAnorakToRepo($Repo->full_github_name);
				$Hook = $Repo->addBuildHookToRepo($Repo->full_github_name);

				// Save the hook in the repo table.
				$Repo->activate($Hook['id']);
			} catch (Exception $e) {
				throw $e;
			}
		}
	}
