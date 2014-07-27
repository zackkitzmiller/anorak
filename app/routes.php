<?php

	Route::get('/', 'HomeController@showIndex');
	Route::get('auth/github', 'GitHubSessionController@authAction');
	Route::get('auth/github/callback', 'GitHubSessionController@authCallbackAction');
	
	Route::group(array('before' => 'auth'), function() {
		Route::get('user', 'UserController@showIndex');
		Route::get('user/logout', 'UserController@logoutAction');
	});

	Route::resource('build', 'BuildController');
