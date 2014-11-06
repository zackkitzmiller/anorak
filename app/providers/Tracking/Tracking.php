<?php

	namespace Anorak\Tracking;

	use Auth;
	use Repo;

	/**
	 * Tracking Model
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Tracking {
		protected $track = TRUE;
		protected $analytics;

		public function __construct($analytics) {
			if(Auth::check() === FALSE) {
				$this->track = FALSE;
				return;
			}

			$this->analytics = new $analytics;

			$this->analytics->init(getenv('SEGMENTIO_WRITE_KEY'));
			$this->analytics->identify([
				'userId' => Auth::user()->id,
				'traits' => [
					'email' => Auth::user()->email_address,
					'stripe_customer_id' => Auth::user()->stripe_customer_id,
					'github_username' => Auth::user()->githubUsername
				]
			]);
		}

		/**
		 * Tracks when a new customer signs up
		 */
		public function trackSignedUp() {
			$this->track([
				'event' => 'Signed Up',
				'context' => [
					'campaign' => $this->campaignParams(),
				],
			]);
		}

		/**
		 * Tracks when a user signs in
		 */
		public function trackSignedIn() {
			$this->track([
				'event' => 'Signed In',
			]);
		}

		/**
		 * Track when a free repository is activated
		 */
		public function trackActivated(Repo $repo) {
			$this->track([
				'event' => 'Activated Public Repo',
				'properties' => [
					'name' => $repo->full_github_name,
				]
			]);
		}

		/**
		 * Track when a free repository is dactivated
		 */
		public function trackDeactivated(Repo $repo) {
			$this->track([
				'event' => 'Deactivated Public Repo',
				'properties' => [
					'name' => $repo->full_github_name,
				]
			]);
		}

		/**
		 * Track when a pull request is reviewed
		 */
		public function trackReviewed(Repo $repo) {
			$this->track([
				'event' => 'Reviewed Repo',
				'properties' => [
					'name' => $repo->full_github_name,
				]
			]);
		}

		/**
		 * Track when a private/organization repo is subscribed
		 */
		public function trackSubscribed(Repo $repo) {
			$this->track([
				'event' => 'Subscribed Private Repo',
				'properties' => [
					'name' => $repo->full_github_name,
					'revenue' => $repo->price,
				]
			]);
		}

		/**
		 * Track when a private/organization repo is unsubscribed
		 */
		public function trackUnsubscribed(Repo $repo) {
			$this->track([
				'event' => 'Unsubscribed Private Repo',
				'properties' => [
					'name' => $repo->full_github_name,
					'revenue' => 0 - ($repo->price),
				]
			]);
		}

		/**
		 * Track an action.
		 *
		 * @return mixed
		 */
		private function track(Array $options) {
			if($this->track) {
				$defaultTrackOptions = [
					'active_repos_count' => Auth::user()->repos()->active()->count(),
					'userId' => Auth::user()->id
				];

				return $this->analytics->track(array_merge($defaultTrackOptions, $options));
			}else{
				return FALSE;
			}
		}

		/**
		 * Returns any campaigns that may have been sent through on sign up
		 *
		 * @return array
		 */
		private function campaignParams() {
			return [
				'medium' => Input::get('utm_medium', ''),
				'name' => Input::get('utm_campaign', ''),
				'source' => Input::get('utm_source', ''),
			];
		}
	}
