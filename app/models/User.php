<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * User Model
 * Default Laravel model for handling the authenticated user.
 *
 * @author James Brooks <jbrooksuk@me.com>
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	protected $hidden = array('remember_token');
	protected $fillable = array('email_address');

	public function memberships() {
		return $this->hasMany('Membership', 'user_id', 'id');
	}

	public function repos() {
		return $this->hasManyThrough('Repo', 'Membership', 'user_id', 'id');
	}

	public function subscriptions() {
		return $this->hasMany('Subscription', 'user_id', 'id');
	}

	public function service() {
		return $this->hasOne('Service', 'user_id', 'id');
	}

	public function githubRepo($GithubID = NULL) {
		return Repo::where('github_id', $GithubID);
	}

	public function createGitHubRepo($Attr) {
		return new Repo($Attr);
	}

	public function getIsGitHubUserAttribute() {
		return !empty($this->service->github_username);
	}

	public function getIsBitBucketUserAttribute() {
		return !empty($this->service->bitbucket_username);
	}

	public function getIsGitLabUserAttribute() {
		return !empty($this->service->gitlab_username);
	}

	public function getGitHubUsernameAttribute() {
		return $this->isGitHubUser ? $this->service->github_username : "";
	}

	public function getBitBucketUsernameAttribute() {
		return $this->isBitBucketUser ? $this->service->bitbucket_username : "";
	}

	public function getGitLabUsernameAttribute() {
		return $this->isGitLabUser ? $this->service->gitlab_username : "";
	}
}
