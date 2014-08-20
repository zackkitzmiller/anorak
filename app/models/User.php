<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laravel\Cashier\BillableTrait;
use Laravel\Cashier\BillableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface, BillableInterface {

	use UserTrait, RemindableTrait, BillableTrait;

	protected $table = 'users';
	protected $hidden = array('remember_token');
	protected $fillable = array('email_address');
	protected $dates = array('trial_ends_at', 'subscription_ends_at');

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
}
