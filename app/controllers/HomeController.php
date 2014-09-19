<?php

	/**
	 * Any "non-dynamic" or generic pages get handled by this controller.
	 */
	class HomeController extends BaseController {

		/**
		 * Shows the index/homepage
		 * @return View
		 */
		public function showIndex() {
			return View::make('index');
		}

		/**
		 * Shows the Privacy Policy page
		 * @return View
		 */
		public function showPrivacy() {
			return View::make('privacy');
		}

	}
