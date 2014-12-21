#!/bin/bash

# Create the Configuration File
echo ">>> Creating the default configuration file .env.local.php"
cd /vagrant && rm .env.local.php
cat >/vagrant/.env.local.php <<EOL
<?php

return array(
// KEEP THESE SECRET!
'GITHUB_CLIENT_ID'     => '', // CHANGE THIS
'GITHUB_CLIENT_SECRET' => '', // CHANGE THIS
'ANORAK_GITHUB_TOKEN'  => 'YOUR-USER-TOKEN',
'ANORAK_GITHUB_USERNAME' => '',

// WHICH QUEUE PRIORITY DO WE PUT THESE CHANGES ON?
'CHANGED_FILES_THRESHOLD' => 10,

// MYSQL Settings
'MYSQL_USERNAME' => 'root',
'MYSQL_PASSWORD' => 'root',

// STRIPE - CHANGE THESE
'STRIPE_SECRET_KEY'      => 'sk_test_foobar',
'STRIPE_PUBLISHABLE_KEY' => 'pk_test_foobar',
);

EOL

# Create The Database
echo ">>> Creating Anorak Database"
cd /vagrant && mysqladmin create anorak -uroot -proot

# Migrate The Database
echo ">>> Migrating the application"
cd /vagrant && php artisan migrate
