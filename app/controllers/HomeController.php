<?php

	class HomeController extends BaseController {

		public function showIndex() {
			return View::make('index');
		}

		public function showPrivacy() {
			return View::make('privacy');
		}

	}
