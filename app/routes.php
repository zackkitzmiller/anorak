<?php

	Route::get('/', 'HomeController@showIndex');
	Route::get('auth/github', 'GitHubSessionController@authAction');
	Route::get('auth/github/callback', 'GitHubSessionController@authCallbackAction');
	
	Route::group(array('before' => 'auth'), function() {
		Route::get('user', 'UserController@showIndex');
		Route::get('user/logout', 'UserController@logoutAction');

		Route::model('repo_id', 'Repo');
		Route::get('repo/{repo_id}/activate', 'RepoController@activate');
		Route::get('repo/{repo_id}/deactivate', 'RepoController@deactivate');
	});

	Route::resource('build', 'BuildController');