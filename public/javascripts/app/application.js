App = angular.module('Anorak', ['ngResource']);

App.config(['$httpProvider', function($httpProvider) {
	$httpProvider.defaults.common.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}]);
