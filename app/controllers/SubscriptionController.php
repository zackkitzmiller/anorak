<?php

	use \Github;

	/**
	 * Handles all subscription based updates.
	 */
	class SubscriptionController extends BaseController {
		public function get(Repo $repo) {
			return $repo->subscription;
		}

		public function subscribe(Repo $repo) {
			return $repo;
		}
	}
