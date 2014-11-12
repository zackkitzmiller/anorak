<?php

	/**
	 * Lines which are changed are represented by this class.
	 */
	class Line {
		public $content;
		public $lineNumber;
		public $patchPosition;

		/**
		 * Setup information about this changed line.
		 * @param integer $number        line number
		 * @param string $content       changes
		 * @param integer $patchPosition where is the patch?
		 */
		public function __construct($lineNumber, $content, $patchPosition) {
			$this->lineNumber = (int) $lineNumber;
			$this->content = $content;
			$this->patchPosition = (int) $patchPosition;

			return $this;
		}

		public function getLineNumber() {
			return $this->lineNumber;
		}

		public function getPatchPos() {
			return $this->patchPosition;
		}

		/**
		 * Always return TRUE because this represents a changed line.
		 * @return bool Always TRUE.
		 */
		public function changed() {
			return TRUE;
		}
	}
