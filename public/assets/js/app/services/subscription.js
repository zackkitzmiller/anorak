App.factory('Subscription', ['$resource', function($resource) {
	return $resource('/repos/:repo_id/subscription', {
		repo_id: '@repo_id'
	});
}]);
