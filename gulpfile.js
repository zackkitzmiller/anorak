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
	mix.sass('styles.scss')
	   .scripts([
			'assets/js/bower_components/angular/angular.js',
			'assets/js/bower_components/angular-resource/angular-resource.js',
			'assets/js/app/application.js',
			'assets/js/app/directives/repo.js',
			'assets/js/app/directives/repo_list.js',
			'assets/js/app/services/repo.js',
			'assets/js/app/services/stripe_checkout.js',
			'assets/js/app/services/subscription.js',
			'assets/js/app/services/sync.js',
			'assets/js/app/services/user.js',
		]).version(['css/styles.css', 'js/all.js']);
});
