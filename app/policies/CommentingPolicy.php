<?php 

	class CommentingPolicy extends Model {
		public function commentPermitted($pullRequest, $prevCommentsOnLine, $violation) {
			$this->violationNotPreviouslyReported($violation->messages, $this->existingMessages($prevCommentsOnLine));
		}

		public function inReview($pullRequest, $line) {
			return $pullRequest->opened || stristr($pullRequest->head, $line);
		}

		public function violationNotPreviouslyReported($newMessages, $existingMessages) {
			return empty($newMessages) && empty($existingMessages);
		}

		public function existingMessages($comments) {
			return array_map(function($body) {
				echo $body;
			}, $comments);
		}
	}