<?php

	Route::model('repo_id', 'Repo');

	Route::get('/', 'HomeController@showIndex');
	Route::get('auth/github', 'GitHubSessionController@authAction');
	Route::get('auth/github/callback', 'GitHubSessionController@authCallbackAction');
	
	Route::group(array('before' => 'auth'), function() {
		Route::get('user', 'UserController@showIndex');
		Route::get('user/logout', 'UserController@logoutAction');
		Route::get('user/setup', 'UserController@showSetup');
	});

	// Route::group(array('before' => 'csrf|auth'), function() {
	Route::group(array('before' => 'auth'), function() {
		Route::any('repo/{repo_id}/activate', 'RepoController@activate');
		Route::any('repo/{repo_id}/deactivate', 'RepoController@deactivate');
	});

	Route::post('build/{repo_id}', 'BuildController@build');