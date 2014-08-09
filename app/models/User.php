<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';
	protected $hidden = array('remember_token');
	protected $fillable = array('github_username', 'email_address');

	public function memberships() {
		return $this->hasMany('Membership', 'user_id', 'id');
	}

	public function repos() {
		return $this->hasManyThrough('Repo', 'Membership', 'user_id', 'repo_id');
	}

	public function createGitHubRepo($Attr) {
		return new Repo($Attr);
	}
}
