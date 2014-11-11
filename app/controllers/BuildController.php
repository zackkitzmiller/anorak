<?php

	/**
	 * The BuildController is what handles all routes to the builder.
	 */
	class BuildController extends BaseController {
		/**
		 * "Builds" a repository.
		 * The job is placed in a queue.
		 *
		 * @return array
		 */
		public function build($github_id) {
			$payload = new Payload(json_decode(Request::getContent(), TRUE));

			try {
				$repo = Repo::where('github_id', $github_id)->first();
			} catch (Exception $e) {
				App::abort(404, "Repository not found");
			}

			// It's a test (ping), say hi.
			if (Request::header('X-GitHub-Event') === 'ping') {
				return Response::make(['ping' => 'OK']);
			}

			// Only comment when the pull request is opened or synchronized.
			if (!$payload->relevant()) {
				return Response::make([
					'errors'  => [
						'Irrelevant pull request'
					],
					'success' => FALSE
				], 200);
			}

			Queue::push('BuildRunnerJob', ['repo' => $repo, 'payload' => $payload->toArray()]);

			Tracking::trackReviewed($repo);

			return Response::make(array(
				'errors'     => [],
				'success'    => TRUE
			));
		}
	}
