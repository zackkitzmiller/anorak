App.directive('repo', ['Subscription', 'StripeCheckout', function(Subscription, StripeCheckout) {
	return {
		scope: true,
		templateUrl: '/templates/repo',
		link: function(scope, element, attributes) {
			var activateRepo, createSubscription, deactivateRepo, deleteSubscription;
			activateRepo = function() {
				scope.processing = true;
				return scope.repo.$activate()["catch"](function() {
					return alert('Your repo failed to activate.');
				})["finally"](function() {
					return scope.processing = false;
				});
			};
			deactivateRepo = function() {
				scope.processing = true;
				return scope.repo.$deactivate()["catch"](function() {
					return alert('Your repo failed to deactivate.');
				})["finally"](function() {
					return scope.processing = false;
				});
			};
			createSubscription = function(stripeToken) {
				var subscription;
				scope.processing = true;
				subscription = new Subscription({
					repo_id: scope.repo.id,
					card_token: stripeToken.id,
					email_address: stripeToken.email
				});
				return subscription.$save().then(function(response) {
					scope.repo.active = true;
					return scope.repo.stripe_subscription_id = response.stripe_subscription_id;
				})["catch"](function() {
					return alert('Your subscription failed.');
				})["finally"](function() {
					return scope.processing = false;
				});
			};
			deleteSubscription = function() {
				var subscription;
				scope.processing = true;
				subscription = new Subscription({
					repo_id: scope.repo.id
				});
				return subscription.$delete().then(function() {
					scope.repo.active = false;
					return scope.repo.stripe_subscription_id = null;
				})["catch"](function() {
					return alert('Your repo could not be disabled');
				})["finally"](function() {
					return scope.processing = false;
				});
			};
			return scope.toggle = function() {
				if (scope.repo.active) {
					if (scope.repo.stripe_subscription_id) {
						return deleteSubscription();
					} else {
						return deactivateRepo();
					}
				} else {
					if (scope.repo.price_in_cents > 0) {
						return StripeCheckout.open({
							name: scope.repo.full_plan_name,
							amount: scope.repo.price_in_cents
						}, createSubscription);
					} else {
						return activateRepo();
					}
				}
			};
		}
	};
}]);
