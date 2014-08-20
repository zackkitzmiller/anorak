<?php 

	use Illuminate\Database\Eloquent\Collection;

	class Violation extends Collection {
		public function lineNumber() {
			return $this->items->lineNumber;
		}
	}