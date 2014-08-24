<?php 

	class Line {
		public $content;
		public $lineNumber;
		public $patchPosition;

		public function __construct($content, $lineNumber, $patchPosition) {
			$this->content = $content;
			$this->lineNumber = $lineNumber;
			$this->patchPosition = $patchPosition;
			return $this;
		}

		public function eq($otherLine) {
			return $this->content === $otherLine->content;
		}
	}