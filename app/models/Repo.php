<?php 

	use \Github\Client as GithubClient;

	class Repo extends Eloquent {
		protected $fillable = array('github_id', 'full_github_name', 'private', 'active', 'hook_id', 'in_organization');

		protected $Client;

		public function __construct() {
			try {
				$this->Client = new GithubClient;
				$this->Client->authenticate(getenv('GITHUB_CLIENT_ID'), Session::get('github.token'));
			} catch (Exception $e) {
				
			}
		}

		public function users() {
			return $this->hasManyThrough('User', 'Memberships', 'user_id', 'id');
		}

		public function memberships() {
			return $this->hasMany('Membership', 'user_id', 'id');
		}

		public function builds() {
			return $this->hasMany('Build', 'build_id', 'id');
		}

		public function scopeAction($query) {
			return $query->where('active', 1);
		}

		public function addAnorakToRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->api('repo')->collaborators()->add($Username, $RepoName, 'anorakci');
		}

		public function addBuildHookToRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->api('repo')->hooks()->create($Username, $RepoName, array(
				'name' => 'web',
				'config' => array(
					'url' => Config::get('app.url') . '/build/' . $this->id,
					'content_type' => 'json',
				),
				'events' => array('pull_request')
			));
		}

		public function removeAnorakFromRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->api('repo')->collaborators()->remove($Username, $RepoName, 'anorakci');
		}

		public function removeBuildHookFromRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->api('repo')->hooks()->remove($Username, $RepoName, $this->hook_id);
		}

		public function activate($HookID) {
			$this->active = 1;
			$this->hook_id = $HookID;
			return $this->update();
		}

		public function deactivate() {
			$this->active = 0;
			$this->hook_id = NULL;
			return $this->update();
		}

		public function plan() {
			if($this->private === 1) {
				if($this->in_organization === 1) {
					return "organization";
				}else{
					return "personal";
				}
			}else{
				return "free";
			}
		}
	}