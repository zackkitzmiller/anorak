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
		Route::get('user/sync', 'UserController@syncAction');
		Route::get('user/repos', 'UserController@reposAction');

		Route::get('repo/{repo_id}/subscription', 'SubscriptionController@get');
		Route::post('repo/{repo_id}/subscription', 'SubscriptionController@subscribe');
	});

	Route::group(array('before' => 'csrf|auth'), function() {
		Route::post('repo/{repo_id}/activate', 'RepoController@activate');
		Route::post('repo/{repo_id}/deactivate', 'RepoController@deactivate');
	});

	Route::any('build/{repo_id}', 'BuildController@build');
