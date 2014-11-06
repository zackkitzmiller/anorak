<?php

	/**
	 * CommitFile
	 * Every file in a Commit is wrapped in this.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class CommitFile {
		protected $File;
		protected $Commit;

		public function __construct($File, $Commit) {
			$this->File = $File;
			$this->Commit = $Commit;
		}

		public function sha() {
			return $this->File['sha'];
		}

		public function filename() {
			return $this->File['filename'];
		}

		public function content() {
			if(!$this->removed()) {
				return $this->Commit->fileContent($this->filename());
			}else{
				return FALSE;
			}
		}

		public function removed() {
			return $this->File['status'] === 'removed';
		}

		public function changedLines() {
			return $this->patch()->changedLines();
		}

		public function lineAt($lineNumber) {
			return array_map(function($modifiedLine) {
				return $modifiedLine->lineNumber === (int)$lineNumber;
			}, $this->changedLines());
		}

		private function patch() {
			return new Patch($this->File['patch']);
		}
	}
