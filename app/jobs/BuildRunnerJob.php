<?php 

	use \Github;
	
	class BuildRunnerJob {
		public function fire($job, $data) {
			$job->delete();

			// This is going to be a really long that should fail some kind of standard. Let's double check.
		}
	}