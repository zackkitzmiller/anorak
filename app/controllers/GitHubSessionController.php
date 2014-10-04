<?php 

	use \League\OAuth2\Client\Provider\GitHub as OAuth;

	/**
	 * Handles any GitHub authentications.
	 */
	class GitHubSessionController extends BaseController {
		private $provider;

		/**
		 * Setups up a new GitHubOAuth Provider class.
		 * @return void
		 */
		public function __construct() {
			$this->provider = new GitHubOAuth(Config::get('social.github'));
		}

		/**
		 * On authentication, redirect the user to the Anorak GitHub auth URL.
		 * @return void
		 */
		public function authAction() {
			header('Location: ' . $this->provider->getAuthorizationUrl());
			exit;
		}

		/**
		 * When the user returns back to Anorak, log them into the system
		 * @return Redirect
		 * @SuppressWarnings checkUnusedVariables
		 */
		public function authCallbackAction() {
			if (Auth::check()) {
				return Redirect::to('/user');
			}

			if (Input::has('code')) {
				$code = Input::get('code');
				try {
					$token = $this->provider->getAccessToken('authorization_code', array(
						'code' => $code,
						'grant_type' => 'authorization_code'
					));
				} catch (Exception $e) {
					App::abort(500);
				}

				$ghUser = $this->provider->getUserDetails($token);

				// Fix for #44
				// Don't allow blank email addresses. No error yet.
				if (is_null($ghUser->email)) {
					return Redirect::to('/');
				}

				$user = User::firstOrCreate(array(
					'email_address' => $ghUser->email
				));

				// Add the GitHub username to the session list
				$user->created(function($user) use ($ghUser) {
					$ghService = new Service;
					$ghService->user_id = $user->id;
					$ghService->github_username = $ghUser->nickname;
					$ghService->save();
				});

				Auth::login($user);

				Tracking::trackSignedIn();

				Session::put('github.token', $token->accessToken);

				// If the user currently has repositories, don't sync.
				if (Auth::user()->repos->count() === 0) {
					Queue::push('RepoSynchronizationJob', array('github_token' => $token->accessToken, 'user_id' => Auth::user()->id));
				}

				return Redirect::to('user');
			} else {
				return Redirect::to('/')->with('error', 'Expired signin session.');
			}
		}

	}