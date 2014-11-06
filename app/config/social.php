<?php

	return array(
		'github' => array(
			'clientId'     => getenv('GITHUB_CLIENT_ID'),
			'clientSecret' => getenv('GITHUB_CLIENT_SECRET'),
			'redirectUri'  => url('/auth/github/callback'),
			'scopes'       => 'user:email repo'
		),
	);
