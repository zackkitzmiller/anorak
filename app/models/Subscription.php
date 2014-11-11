<?php

	/**
	 * Subscription Model
	 * Used to handle all of the subscriptions that a user is paying for a repo.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Subscription extends Eloquent {
		public function user() {
			return $this->belongsTo('user', 'user_id', 'id');
		}

		public function repo() {
			return $this->belongsTo('repo', 'repo_id', 'id');
		}
	}
