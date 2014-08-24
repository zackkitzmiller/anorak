<?php 

	/**
	 * Build Model
	 * Stores all of the repository builds in which have violations.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Build extends Eloquent {
		public static function boot() {
			parent::boot();

			static::saving(function($Build) {
				$Build->uuid = Uuid::generate();
			});
		}

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
	}