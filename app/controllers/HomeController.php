<?php

	class HomeController extends BaseController {

		public function showIndex() {
			return View::make('index');
		}

		public function showTest() {
			$Test = new TestCollection(array('One', 'Two'));
			dd($Test->hello());
		}

	}
