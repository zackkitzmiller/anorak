<?php

	/**
	 * Service Model
	 * Store the username for the service the user has logged into.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Service extends Eloquent {
		public function user() {
			return $this->belongsTo('user', 'user_id', 'id');
		}
	}
