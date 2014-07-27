<?php 

	use \Github;

	class SmallBuildJob {
		public function fire($job, $data) {
			$job->delete();
		}
	}