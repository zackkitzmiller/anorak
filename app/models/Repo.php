<?php 

	class Repo extends Eloquent {
		public function users() {
			return $this->hasManyThrough('User', 'Memberships', 'user_id', 'id');
		}

		public function memberships() {
			return $this->hasMany('Memberships', 'user_id', 'id');
		}

		public function builds() {
			return $this->hasMany('Build', 'build_id', 'id');
		}

		public function deactivate() {
			$this->active = 0;
			$this->hook_id = NULL;
			return $this->update();
		}
	}