<?php 

	use \Github;

	class EmailAddressJob {
		public function fire($job, $data) {
			$User = User::find($data['user_id']);

			$job->delete();
		}
	}