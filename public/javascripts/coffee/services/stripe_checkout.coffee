App.factory 'StripeCheckout', ->
	open: (options, successCallback) ->
		StripeCheckout.configure(
			key: Settings.stripePublishableKey,
			image: '<%= image_path('logo-square.png') %>',
			token: successCallback
		).open(
			angular.extend(
				options,
				email: Settings.userEmailAddress,
				panelLabel: '{{amount}} per month',
				allowRememberMe: false
			)
		)
