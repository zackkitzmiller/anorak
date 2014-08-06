<?php

	use \Github;

	class UserController extends BaseController {

		public function showIndex() {
			return View::make('user.index');
		}

		public function logoutAction() {
			Auth::logout();

			return Redirect::to('/');
		}

		public function showSetup() {
			return View::make('user.setup');
		}

	}
