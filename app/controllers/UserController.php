<?php

	use \Github;

	/**
	 * User controller.
	 */
	class UserController extends BaseController {

		/**
		 * Shows the users repository list.
		 * @return View
		 */
		public function showIndex() {
			return View::make('user.index');
		}

		/**
		 * Shows the users account information.
		 * Mainly, what they're subscribed to and how much they're paying.
		 * @return View
		 */
		public function showAccount() {
			return View::make('user.account');
		}

		/**
		 * Logs the user out and returns them to the homepage
		 * @return Redirect
		 */
		public function logoutAction() {
			Auth::logout();

			return Redirect::to('/');
		}

		/**
		 * Display a "how to setup" page.
		 * @return View
		 */
		public function showSetup() {
			return View::make('user.setup');
		}

		/**
		 * Syncs up user repositories.
		 * @return array
		 */
		public function syncAction() {
			Queue::push('RepoSynchronizationJob', array('github_token' => Session::get('github.token'), 'user_id' => Auth::user()->id));

			return [
				'success' => true
			];
		}

		/**
		 * Returns all of a users repositories.
		 * @return array
		 */
		public function reposAction() {
			return Auth::user()->repos;
		}

	}
