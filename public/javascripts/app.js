(function() {
	!function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
	arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
	d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
	insertBefore(d,q)}(window,document,'script','_gs');
	_gs('GSN-279675-G');

	App = angular.module('Anorak', ['ngResource']);

	App.config(['$httpProvider', function($httpProvider) {
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
	}]);
}());
