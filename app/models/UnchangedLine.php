<?php 
	
	/**
	 * Unchanged Lines
	 */
	class UnchangedLine {
		public $patchPosition = -1;

		/**
		 * Always returns FALSE, because this is an unchanged line.
		 * @return bool Always FALSE
		 */
		public function changed() {
			return FALSE;
		}
	}