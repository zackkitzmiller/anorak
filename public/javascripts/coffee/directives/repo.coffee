App.directive 'repo', ['Subscription', 'StripeCheckout', (Subscription, StripeCheckout) ->
	scope: true
	templateUrl: '/templates/repo'
	link: (scope, element, attributes) ->
		activateRepo = ->
			scope.processing = true
]
