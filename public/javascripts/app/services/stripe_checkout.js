App.factory('StripeCheckout', function() {
	return {
		open: function(options, successCallback) {
			return StripeCheckout.configure({
				key: setup.stripePublishableKey,
				image: '/images/Anorak.png',
				token: successCallback
			}).open(angular.extend(options, {
				email: setup.userEmailAddress,
				panelLabel: '{{amount}} per month',
				allowRememberMe: false
			}));
		}
	};
});
