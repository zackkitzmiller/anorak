<?php

	Route::get('/', function() {
		return View::make('index');
	});

	Route::get('/auth/github', 'SessionController@authAction');
	Route::get('/auth/github/callback', 'SessionController@authCallbackAction');