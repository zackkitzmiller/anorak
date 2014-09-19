<?php 

	use \Github;

	/**
	 * All Repository access is handled by this controller.
	 * Activations/Deactivations etc.
	 */
	class RepoController extends BaseController {
		/**
		 * Activates a repository. With auth checking.
		 * Setups a GitHub web hook, assigns the id in our db. Done.
		 * @param  Repo $repo
		 * @return Response
		 */
		public function activate(Repo $repo) {
			// Only allow activation of repositories if you're a member of it.
			if ($repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
				return Response::make(array(
					'errors' => array(
						'You must be the owner or a collaborator to activate this repository'
					),
					'success' => FALSE
				), 403);
			}

			try {
				// Do stuff to the GitHub side of things.
				$repo->addAnorakToRepo($repo->full_github_name);
				$hook = $repo->addBuildHookToRepo($repo->full_github_name);

				// Save the hook in the repo table.
				if ($repo->activate($hook['id'])) {
					Tracking::trackActivated($repo);
					return Response::make([
						'errors'  => [],
						'success' => TRUE
					]);
				} else {
					return Response::make([
						'errors' => [
							'Repository could not be activated'
						],
						'success' => FALSE
					], 500);
				}
			} catch (Exception $exception) {
				return Response::make([
					'errors' => [
						$exception->getMessage()
					],
					'success' => FALSE
				], 403);
			}
		}

		/**
		 * Deactivates a repository. With auth checking.
		 * Removes the GitHub web hook, unassigns the id in our db. Done.
		 * @param  Repo $repo
		 * @return Response
		 */
		public function deactivate(Repo $repo) {
			// Only allow deactivation of repositories if you're a member of it.
			if ($repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
				return Response::make(array(
					'errors' => array(
						'You must be the owner or a collaborator to deactivate this repository'
					),
					'success' => FALSE
				), 403);
			}

			try {
				// Do stuff to the GitHub side of things.
				$repo->removeAnorakFromRepo($repo->full_github_name);
				$repo->removeBuildHookFromRepo($repo->full_github_name);

				// Remove the hook_id and deactivate from the repo table.
				if ($repo->deactivate()) {
					// Only allow activation of repositories if you're a member of it.
					if ($repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
						Tracking::trackDeactivated($repo);
						return Response::make(array(
							'errors' => array(),
							'success' => TRUE
						));
					}
				} else {
					// Only allow activation of repositories if you're a member of it.
					if ($repo->memberships()->where('user_id', Auth::user()->id)->count() === 0) {
						return Response::make(array(
							'errors' => array(
								'Repository could not be deactivated'
							),
							'success' => FALSE
						), 500);
					}
				}
			} catch (Exception $exception) {
				return Response::make(array(
					'errors' => array(
						$exception->getMessage()
					),
					'success' => FALSE
				), 403);
			}
		}
	}
