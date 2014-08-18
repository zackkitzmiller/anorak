<?php 

	class Subcription extends Eloquent {
		protected $table = 'subscriptions';
		
		public function user() {
			return $this->belongsTo('user', 'user_id', 'id');
		}

		public function repo() {
			return $this->belongsTo('repo', 'repo_id', 'id');
		}
	}