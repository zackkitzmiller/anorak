App.factory('User', ['$resource', function($resource) {
	return $resource('/user');
}]);
