<?php 

	use Illuminate\Database\Eloquent\Collection;

	class TestCollection extends Collection {
		public function hello() {
			dd($this->items);
		}
	}