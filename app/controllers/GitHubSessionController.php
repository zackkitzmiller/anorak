<?php 

	use \League\OAuth2\Client\Provider\GitHub as OAuth;

	class GitHubSessionController extends BaseController {
		private $Provider;

		public function __construct() {
			$this->Provider = new GitHubOAuth(Config::get('social.github'));
		}

		public function authAction() {
			header('Location: ' . $this->Provider->getAuthorizationUrl());
			exit;
		}

		public function authCallbackAction() {
			if($Code = Input::get('code')) {
				try {
					$Token = $this->Provider->getAccessToken('authorization_code', array(
						'code' => $Code,
						'grant_type' => 'authorization_code'
					));
				}catch(Exception $e) {
					App::abort(500);
				}

				$GhU = $this->Provider->getUserDetails($Token);

				$User = User::firstOrCreate(array(
					'github_username' => $GhU->nickname,
					'email_address'   => $GhU->email
				));

				Auth::login($User);

				Session::put('github.token', $Token->accessToken);

				// If the user currently has repositories, don't sync.
				if(Auth::user()->repos->count() === 0) {
					Queue::push('RepoSynchronizationJob', array('github_token' => $Token->accessToken, 'user_id' => Auth::user()->id));
				}			

				return Redirect::to('user');
			}else{
				return Redirect::to('/')->with('error', 'Expired signin session.');
			}
		}

		public function signinAction() {

		}

		public function signoutAction() {
			Auth::logout();
			return Redirect::to('/');
		}

	}