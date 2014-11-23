App.directive('repoList', ['Repo', 'Sync', 'User', '$timeout', function(Repo, Sync, User, $timeout) {
	return {
		scope: {},
		templateUrl: '/templates/repo_list',
		link: function(scope, element, attributes) {
			var loadRepos, pollSyncStatus;
			loadRepos = function() {
				var repos;
				scope.syncingRepos = false;
				repos = Repo.query();
				return repos.$promise.then(function(results) {
					return scope.repos = results;
				}, function() {
					return alert('Your repos failed to load.');
				});
			};
			pollSyncStatus = function() {
				var failedSync, getSyncs, successfulSync;
				successfulSync = function(user) {
					if (user.refreshing_repos) {
						return pollSyncStatus();
					} else {
						return loadRepos();
					}
				};
				failedSync = function() {
					return pollSyncStatus();
				};
				getSyncs = function() {
					var user;
					user = User.get();
					return user.$promise.then(successfulSync, failedSync);
				};
				return $timeout(getSyncs, 3000);
			};
			scope.sync = function() {
				var sync;
				scope.syncingRepos = true;
				return sync = Sync.save().$promise.then(function() {
					return pollSyncStatus();
				}, function() {
					scope.syncingRepos = false;
					return alert('Your repos failed to sync.');
				});
			};
			scope.$watch('syncingRepos', function(newValue, oldValue) {
				if (newValue) {
					return scope.syncButtonText = 'Sycning repos';
				} else {
					return scope.syncButtonText = 'Sync';
				}
			});
			return loadRepos().then(function() {
				if (scope.repos.length < 1) {
					return scope.sync();
				}
			});
		}
	};
}]);
