<?php 

	class Repo extends Eloquent {
		protected $fillable = array('github_id', 'full_github_name', 'private', 'active', 'hook_id', 'in_organisation');

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