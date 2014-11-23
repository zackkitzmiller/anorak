App.factory('Sync', ['$resource', function($resource) {
	return $resource('/user/sync');
}]);
