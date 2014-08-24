<?php 

	class BuildController extends BaseController {
		public function build(Repo $Repo) {
			$Payload = new Payload(json_decode(Request::getContent(), TRUE));

			// It's a test (ping), say hi.
			if(Request::header('X-GitHub-Event') === 'ping') return Response::make(['ping' => 'OK']);

			// Only comment when the pull request is opened or synchronized.
			if(!$Payload->relevant()) {
				return Response::make([
					'errors'  => [
						"Irrelevant pull request"
					],
					'success' => FALSE
				], 403);
			}

			Queue::push('BuildRunnerJob', ['Repo' => $Repo, 'Payload' => $Payload->toArray()]);

			return Response::make(array(
				'errors'     => [],
				'success'    => TRUE
			));
		}
	}
