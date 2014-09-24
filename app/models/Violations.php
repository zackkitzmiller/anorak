<?php 

	class Violations {
		public $violations = array();

		public function __construct($violations) {
			$this->violations = array();

			$this->push($violations);

			return $this;
		}

		public function push($violations) {
			foreach ($violations as $violation) {
				$identifier = $violation->filename . ':' . $violation->lineNumber;

				if (!isset($this->violations[$identifier])) {
					$this->violations[$identifier] = $violation;
				} else {
					// What is this?
					$this->violations[$identifier]->addMessages($violation->messages);
				}
			} 

			return $this;
		}

		/**
		 *   private
		 *	 def each(&block)
		 *	   changed_line_violations.each(&block)
		 *	 end
		 *	 def changed_line_violations
		 *	   @violations.values.select(&:on_changed_line?)
		 *	 end
		 */
	}