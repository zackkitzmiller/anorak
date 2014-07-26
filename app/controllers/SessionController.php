<?php 

	use \League\OAuth2\Client\Provider\GitHub as OAuth;
	use \GitHub\Client;

	class SessionController extends BaseController {
		const USER_AGENT = 'Anorak';

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

				return Redirect::to('user');
			}else{
				return Redirect::to('/')->with('error', 'Expired signin session.');
			}
		}

		public function signinAction() {

		}

		public function signoutAction() {

		}

	}