<?php 

	class Build extends Eloquent {
		public function repo() {
			return $this->belongsTo('Repo', 'repo_id', 'id');
		}

		public function getStatusAttribute() {
			if(!empty($this->violations)) {
				return 'failed';
			}else{
				return 'passed';
			}
		}

		private function generateUUID() {
			return Uuid::generate();
		}
	}