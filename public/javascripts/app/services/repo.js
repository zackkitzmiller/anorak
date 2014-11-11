App.factory('Repo', ['$resource', function($resource) {
	return $resource('/repos/:id', {
		id: '@id'
	}, {
		activate: {
			method: 'POST',
			url: 'repos/:id/activate'
		},
		deactivate: {
			method: 'POST',
			url: 'repos/:id/deactivate'
		}
	});
}]);
