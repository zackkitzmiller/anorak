<?php 

	use \Github;

	class LargeBuildJob {
		public function fire($job, $data) {
			$job->delete();
		}
	}