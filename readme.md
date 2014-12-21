![Anorak](http://anorakci.com/images/AnorakFull.png)

[![Dependency Status](https://www.versioneye.com/user/projects/54213d0b3a1a2c496b000286/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54213d0b3a1a2c496b000286)

PHP code reviews with Anorak.

## Development
Developing Anorak is fairly straight forward, there are just a few things that need setting up before you can get on your way.

1. Clone the repository.
2. On first clone run `composer install`, any subsequent pulls you should run `composer update` to update all dependencies.
3. Create a `.env.local.php` file in the root of the `anorak` directory:
    ```php
    <?php

        return array(
            // KEEP THESE SECRET!
            'GITHUB_CLIENT_ID'     => '', // CHANGE THIS
            'GITHUB_CLIENT_SECRET' => '', // CHANGE THIS
            'ANORAK_GITHUB_TOKEN'  => 'YOUR-USER-TOKEN',
            'ANORAK_GITHUB_USERNAME' => 'anorakci',

            // WHICH QUEUE PRIORITY DO WE PUT THESE CHANGES ON?
            'CHANGED_FILES_THRESHOLD' => 10,

            // MYSQL Settings
            'MYSQL_USERNAME' => 'mysql-user',
            'MYSQL_PASSWORD' => 'mysql-pass',

            // STRIPE - CHANGE THESE
            'STRIPE_SECRET_KEY'      => 'sk_test_foobar',
            'STRIPE_PUBLISHABLE_KEY' => 'pk_test_foobar',
        );
    ?>
    ```
4. Ensure that you have a VHOST setup and that `anorakci.com.dev` is added to your `HOSTS` file.
5. Run `php artisan migrate` to run any new database migrations.
6. Install Node.js dependencies (Gulp and Elixir), `npm install`
7. Your good to go.

## Gulp
Anorak uses Gulp & Elixir to compile the JavaScript code into one file.

If you don't already have the `gulp` command installed, you'll need to run this:

```bash
$ npm install --global gulp
```

## Vagrant
If you're using vagrant, a `Vagrantfile` is provided. You can start the Anorak Virtual Machine with `$ vagrant up`

Works with both VMWare and VirtualBox

## Testing
Anorak has zero tests so far. Ideally everything should be tested using PHPUnit, but I don't have much experience in it.

## Contributing
Some basic rules to code:

1. Don't squash your commits. You're rewriting history.
2. Create a merge request with your changes. Anorak should comment on itself if it's working.

## License

Copyright 2014 James Brooks

Simple license agreement:

- You may not distribute this source code.
- You may not modify it to create a competitor product.
