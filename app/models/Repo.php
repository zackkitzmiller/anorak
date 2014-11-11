<?php

	use \Github\Client as GithubClient;

	/**
	 * Repo Model
	 * Repository model.
	 *
	 * @author James Brooks <jbrooksuk@me.com>
	 */
	class Repo extends Eloquent {
		protected $fillable = array('github_id', 'full_github_name', 'private', 'active', 'hook_id', 'in_organization');
		protected $guarded  = array();
		protected $appends  = array('username', 'reponame');

		protected $Client;

		public function __construct() {
			try {
				$this->Client = new GithubClient;
				$this->Client->authenticate(getenv('GITHUB_CLIENT_ID'), Session::get('github.token'));
			} catch (Exception $e) {
				// TODO: Throw some kind of Internal Server Error.
				// Use StatusPage.io
			}
		}

		public function users() {
			return $this->hasManyThrough('User', 'Memberships', 'user_id', 'id');
		}

		public function memberships() {
			return $this->hasMany('Membership');
		}

		public function builds() {
			return $this->hasMany('Build', 'build_id', 'id');
		}

		public function scopeActive($query) {
			return $query->where('active', 1);
		}

		public function addAnorakToRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->repo()->collaborators()->add($Username, $RepoName, 'anorakci');
		}

		public function addBuildHookToRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->repo()->hooks()->create($Username, $RepoName, array(
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

			return $this->Client->repo()->collaborators()->remove($Username, $RepoName, 'anorakci');
		}

		public function removeBuildHookFromRepo($Repo) {
			list($Username, $RepoName) = explode('/', $Repo);

			return $this->Client->repo()->hooks()->remove($Username, $RepoName, $this->hook_id);
		}

		public function activate($HookID) {
			$this->active = 1;
			$this->hook_id = $HookID;
			return $this->update();
		}

		public function deactivate() {
			$this->active = 0;
			$this->hook_id = null;
			return $this->update();
		}

		public function price() {
			return Config::get('subscriptions')[$this->plan];
		}

		public function getUsernameAttribute() {
			return $this->_getName()[0];
		}

		public function getReponameAttribute() {
			return $this->_getName()[1];
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

		private function _getName() {
			return explode('/', $this->full_github_name);
		}
	}
