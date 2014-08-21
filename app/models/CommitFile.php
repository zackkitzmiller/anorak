<?php 

	class CommitFile {
		protected $File;
		protected $Commit;

		public function __construct($File, $Commit) {
			$this->File = $File;
			$this->Commit = $Commit;
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

		public function modifiedLines() {
			return $this->patch()['additions'];
		}

		public function modifiedLineAt($lineNo) {
			/*modified_lines.detect do |modified_line|
				modified_line.line_number == line_number
			end*/
		}

		private function patch() {
			return new Patch($this->File['patch']);
		}
	}