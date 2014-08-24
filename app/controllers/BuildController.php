<?php 

	class BuildController extends BaseController {
		public function build(Repo $Repo) {
			list($User, $RepoName) = explode('/', $Repo->full_github_name);

			$Payload = new Payload(json_decode(Request::getContent(), TRUE));
			// $Payload = new Payload(json_decode(file_get_contents(storage_path() . '/pullrequest-afro-11.json'), TRUE));
			$Event = Request::header('X-GitHub-Event');

			// It's a test (ping), say hi.
			if($Event === 'ping') return Response::make(['ping' => 'OK']);

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
