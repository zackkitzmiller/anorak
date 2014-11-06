<?php

	/**
	 * Membership Model
	 * Links up all of the Repo to Users.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Membership extends Eloquent {
		protected $fillable = array('user_id', 'repo_id');

		public function user() {
			return $this->belongsTo('User', 'user_id', 'id');
		}

		public function repo() {
			return $this->belongsTo('repo', 'user_id', 'id');
		}
	}
