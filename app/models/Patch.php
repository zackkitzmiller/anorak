<?php 

	use Illuminate\Database\Eloquent\Collection;

	/**
	 * Patch
	 * Allows us to comment specifically on the patch line.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Patch {
		const RANGE_INFORMATION_LINE = "/^@@ .+\+(\d+),/";
		const MODIFIED_LINE = "/^\+(?!\+|\+)/";
		const NOT_REMOVED_LINE = "/^[^-]/";

		protected $Body;

		public function __construct($Body = '') {
			$this->Body = $Body;
		}

		public function changedLines() {
			$lineNumber = 0;
			$lines  = [];

			foreach($this->lines() as $patchPos => $content) {
				if ($line = preg_match(self::RANGE_INFORMATION_LINE, $content)) {
					$lineNumber = (int)$line[$lineNumber];
				} elseif ($line = preg_match(self::MODIFIED_LINE, $content)) {
					$lines[] = [
						'content'       => $content, 
						'lineNumber'    => (int)$lineNumber,
						'patchPosition' => (int)$patchPos
					];
					
					$lineNumber++;
				} elseif ($line = preg_match(self::NOT_REMOVED_LINE, $content)) {
					$lineNumber++;
				}
			}

			return new Collection($lines);
		}

		private function lines() {
			return preg_split("/\n/", $this->Body);
		}
	}