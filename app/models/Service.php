<?php 

	class Service extends Eloquent {
		public function user() {
			return $this->belongsTo('user', 'user_id', 'id');
		}
	}