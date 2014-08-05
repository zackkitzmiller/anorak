<?php

	Route::model('repo_id', 'Repo');

	Route::get('/', 'HomeController@showIndex');
	Route::get('auth/github', 'GitHubSessionController@authAction');
	Route::get('auth/github/callback', 'GitHubSessionController@authCallbackAction');
	
	Route::group(array('before' => 'auth'), function() {
		Route::get('user', 'UserController@showIndex');
		Route::get('user/logout', 'UserController@logoutAction');
	});

	// TODO: Put the CSRF filter back in once the website is working
	Route::group(array('before' => 'auth'), function() {
		Route::get('repo/{repo_id}/activate', 'RepoController@activate');
		Route::get('repo/{repo_id}/deactivate', 'RepoController@deactivate');
	});

	Route::post('build/{repo_id}', 'BuildController@build');