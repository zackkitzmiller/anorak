<?php 

	class BuildController extends BaseController {
		public function build(Repo $Repo) {
			$Payload = Input::get('payload');
			$Event   = Request::header('X-GitHub-Event');

			// It's a test (ping), say hi.
			if($Event === 'ping') {
				return Response::make(array(
					'ping' => 'OK'
				));
			}elseif($Event === 'pull_request'){
				if($Payload['changed_files'] < $_ENV['CHANGED_FILES_THRESHOLD']) {
					// Queue::push('SmallBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'high');
				}else{
					// Queue::push('LargeBuildJob', array('payload' => $Payload, 'repo_id' => $Repo->id), 'medium');
				}
			}
		}
	}
