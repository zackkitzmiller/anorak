<?php

	class UserController extends BaseController {

		public function showIndex() {
			return View::make('user.index');
		}

		public function logoutAction() {
			Auth::logout();

			return Redirect::to('/');
		}

	}
