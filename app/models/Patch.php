<?php 

	use Illuminate\Database\Eloquent\Collection;

	class Patch {
		const RANGE_INFORMATION_LINE = "/^@@ .+\+(\d+),/";
		const MODIFIED_LINE = "/^\+(?!\+|\+)/";
		const NOT_REMOVED_LINE = "/^[^-]/";

		protected $Body;

		public function __construct($Body = '') {
			$this->Body = $Body;
		}

		public function additions() {
			$lineNumber = 0;
			$additions  = [];

			foreach($this->lines() as $patchPos => $content) {
				if($line = preg_match(self::RANGE_INFORMATION_LINE, $content)) {
					$lineNumber = (int)$line[$lineNumber];
				}elseif($line = preg_match(self::MODIFIED_LINE, $content)) {
					$additions[] = [
						'content'       => $content, 
						'lineNumber'    => $lineNumber,
						'patchPosition' => $patchPos
					];
					
					$lineNumber++;
				}elseif($line = preg_match(self::NOT_REMOVED_LINE, $content)) {
					$lineNumber++;
				}
			}

			return new Collection($additions);
		}

		private function lines() {
			return preg_split("/\n/", $this->Body);
		}
	}