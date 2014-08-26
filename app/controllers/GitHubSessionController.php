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
			if($code = Input::get('code')) {
				try {
					$Token = $this->Provider->getAccessToken('authorization_code', array(
						'code' => $code,
						'grant_type' => 'authorization_code'
					));
				}catch(Exception $e) {
					App::abort(500);
				}

				$GithubUser = $this->Provider->getUserDetails($Token);

				// Fix for #44
				// Don't allow blank email addresses. No error yet.
				if(is_null($GithubUser->email)) return Redirect::to('index');

				$User = User::firstOrCreate(array(
					'email_address' => $GithubUser->email
				));

				// Add the GitHub username to the session list
				$GithubService = new Service;
				$GithubService->user_id = $User->id;
				$GithubService->github_username = $GithubUser->nickname;
				$GithubService->save();

				Auth::login($User);

				Tracking::trackSignedIn();

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

	}