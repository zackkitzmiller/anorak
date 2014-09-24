<?php 

	/**
	 * Lines which are changed are represented by this class.
	 */
	class Line {
		public $number;
		public $content;
		public $patchPosition;

		/**
		 * Setup information about this changed line.
		 * @param integer $number        line number
		 * @param string $content       changes
		 * @param integer $patchPosition where is the patch?
		 */
		public function __construct($number, $content, $patchPosition) {
			$this->number = $number;
			$this->content = $content;
			$this->patchPosition = $patchPosition;

			return $this;
		}

		/**
		 * Always return TRUE because this represents a changed line.
		 * @return bool Always TRUE.
		 */
		public function changed() {
			return TRUE;
		}
	}