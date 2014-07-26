<?php 

	class Membership extends Eloquent {
		public function user() {
			return $this->belongsTo('User', 'user_id', 'id');
		}

		public function repo() {
			return $this->belongsTo('repo', 'user_id', 'id');
		}
	}