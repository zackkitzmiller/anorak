![Anorak](http://anorakci.com/images/AnorakFull.png)

![Dependencies](https://www.versioneye.com/user/projects/54213d0b3a1a2c496b000286#dialog_dependency_badge)

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
            'GITHUB_CLIENT_ID'     => '0dd6c37721a10448290e',
            'GITHUB_CLIENT_SECRET' => '25423ebc112be234906fe61f6c2763b012d6a0a9',
            'ANORAK_GITHUB_TOKEN'  => 'YOUR-USER-TOKEN',

            // WHICH QUEUE PRIORITY DO WE PUT THESE CHANGES ON?
            'CHANGED_FILES_THRESHOLD' => 10,

            // MYSQL Settings
            'MYSQL_USERNAME' => 'mysql-user',
            'MYSQL_PASSWORD' => 'mysql-pass',

            // STRIPE
            'STRIPE_SECRET_KEY'      => 'sk_test_Uko8d0VdFq3reGahtVPmOO1r',
            'STRIPE_PUBLISHABLE_KEY' => 'pk_test_qjI4B7vuJyKsn2xFjj8Dxk77',
        );
    ?>
    ```
4. Ensure that you have a VHOST setup and that `anorakci.com.dev` is added to your `HOSTS` file.
5. Run `php artisan migrate` to run any new database migrations.
6. Your good to go.

## Testing
Anorak has zero tests so far. Ideally everything should be tested using PHPUnit, but I don't have much experience in it.

## Contributing
Some basic rules to code:

1. Don't squash your commits. You're rewriting history.
2. Create a merge request with your changes.

## License
I'm not sure what the license on this will be. For now, you are **forbidden** from sharing the code beyond any contributors to this repository.
