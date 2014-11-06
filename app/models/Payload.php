<?php

	use Illuminate\Database\Eloquent\Collection;

	/**
	 * Payload
	 * Wraps the actual Payload JSON data sent to us via the Web Hook.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Payload extends Collection {
		public function headSha() {
			return $this->pullRequest()['head']['sha'];
		}

		public function githubRepoID() {
			return $this->items['repository']['id'];
		}

		public function fullRepoName() {
			return $this->items['repository']['full_name'];
		}

		public function number() {
			return $this->items['number'];
		}

		public function action() {
			return $this->items['action'];
		}

		public function changedFiles() {
			return $this->items['changed_files'] || 0;
		}

		public function ping() {
			return isset($this->items['zen']);
		}

		public function pullRequest() {
			return $this->items['pull_request'];
		}

		public function relevant() {
			return in_array($this->action(), ['opened', 'synchronize']);
		}
	}
