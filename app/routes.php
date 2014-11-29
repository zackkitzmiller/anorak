<?php

	Route::model('repo_id', 'Repo');

	Route::get('/', 'HomeController@showIndex');
	Route::get('privacy', 'HomeController@showPrivacy');
	Route::get('faq', 'HomeController@showFaq');
	Route::get('auth/github', 'GitHubSessionController@authAction');
	Route::get('auth/github/callback', 'GitHubSessionController@authCallbackAction');

	Route::group(array('before' => 'auth'), function() {
		Route::get('user', 'UserController@showIndex');
		Route::get('user/logout', 'UserController@logoutAction');
		Route::get('user/setup', 'UserController@showSetup');
		Route::post('user/sync', 'UserController@syncAction');
		Route::get('user/repos', 'UserController@reposAction');
		Route::get('user/account', 'UserController@showAccount');

		Route::get('repos/{repo_id}/subscription', 'SubscriptionController@get');
		Route::post('repos/{repo_id}/subscription', 'SubscriptionController@subscribe');
		Route::delete('repos/{repo_id}/subscription', 'SubscriptionController@unsubscribe');
	});

	Route::group(array('before' => 'auth'), function() {
		Route::post('repos/{repo_id}/activate', 'RepoController@activate');
		Route::post('repos/{repo_id}/deactivate', 'RepoController@deactivate');
	});

	Route::any('builds/{repo_id}', 'BuildController@build');
