var elixir = require('laravel-elixir');

/*
 |----------------------------------------------------------------
 | Have a Drink!
 |----------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic
 | Gulp tasks for your Laravel application. Elixir supports
 | several common CSS, JavaScript and even testing tools!
 |
 */

elixir(function(mix) {
	mix.sass('stylesheets/styles.scss')
	   .scripts([
			'javascripts/app/angular.js',
			'javascripts/app/angular-resource.js',
			'javascripts/app/application.js',
			'javascripts/app/directives/repo.js',
			'javascripts/app/directives/repo_list.js',
			'javascripts/app/services/repo.js',
			'javascripts/app/services/stripe_checkout.js',
			'javascripts/app/services/subscription.js',
			'javascripts/app/services/sync.js',
			'javascripts/app/services/user.js'
		]);
});
