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
			'assets/js/bower_components/angular-resource/angular-resource.min.js',
			'assets/js/bower_components/angular/angular.min.js',
			// 'js/app/application.js',
			// 'js/app/directives/repo.js',
			// 'js/app/directives/repo_list.js',
			// 'js/app/services/repo.js',
			// 'js/app/services/stripe_checkout.js',
			// 'js/app/services/subscription.js',
			// 'js/app/services/sync.js',
			// 'js/app/services/user.js',
		]).version(['css/styles.css', 'js/all.js']);
});
