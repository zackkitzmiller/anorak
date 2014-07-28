<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

        'GitHub' => array(
            'client_id'     => getenv('CLIENT_ID'),
            'client_secret' => getenv('CLIENT_SECRET'),
            'scope'         => array(),
        ),		

	)

);