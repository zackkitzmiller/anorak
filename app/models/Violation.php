<?php

	class Violation {
		public $lineNumber;
		public $filename;

		private $line;
		private $messages;

		/**
		 * Creates a new Violation class
		 * @param CommitFile $file    a CommitFile class containing the file
		 * @param integer $lineNumber line that the violations are reported on
		 * @param string $message     the message of the violation
		 * @return this itself
		 */
		public function __construct(CommitFile $file, $lineNumber, $message) {
			$this->filename = $file->filename();
			$this->line = $file->lineAt($lineNumber);
			$this->lineNumber = $lineNumber;
			$this->messages[] = $message;

			return $this;
		}

		/**
		 * Add more messages to this violation.
		 * @param this $messages
		 * @return this itself
		 */
		public function addMessages($messages) {
			foreach ($messages as $message) {
				$this->messages[] = $message;
			}

			return $this;
		}

		/**
		 * Only return one of each violation message.
		 * @return array unique violation messages
		 */
		public function messages() {
			return array_unique($this->messages);
		}

		/**
		 * Where was the patch made?
		 * @return integer lines patch position
		 */
		public function patchPosition() {
			return $this->line->patchPosition;
		}

		/**
		 * Returns whether the message was on a changed line.
		 * @return bool line changed?
		 */
		public function onChangedLine() {
			return $this->line->changed();
		}
	}
