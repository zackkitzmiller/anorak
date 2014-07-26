<?php 

	return array(
		'github' => array(
			'clientId'     => $_ENV['GITHUB_CLIENT_ID'],
			'clientSecret' => $_ENV['GITHUB_CLIENT_SECRET'],
			'redirectUri'  => url('/auth/github/callback'),
			'scopes'       => 'user:email repo'
		),
	);