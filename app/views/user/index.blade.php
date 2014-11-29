@extends('layouts.page')

@section('content')
<script>
	var setup = {
		stripePublishableKey: '{{ getenv("STRIPE_PUBLISHABLE_KEY") }}',
		userEmailAddress: '{{ Auth::user()->email_address }}'
	};
</script>

<section>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h1>Your repositories</h1>
				<p class='lead'><strong class="text-danger">Anorak is still in beta and as such may not always be responsive.</strong></p>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-3'></div>
			<div class='col-md-6'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<div class='row'>
							<div class='col-lg-10 col-sm-6'>
								<h3>Repositories</h3>
							</div>
							<div class='col-lg-2 col-sm-6'>
								<a href='javascript: void(0)' data-action='repo_sync' class='btn btn-info btn-lg pull-right'><i class='fa fa-refresh'></i></a>
							</div>
						</div>
					</div>
					<div class='panel-body'>
						@{{(repos | filter:{active: true}).length}} of @{{repos.length}}
					</div>
				</div>
			</div>
			<div class='col-md-3'></div>
		</div>
	</div>
</section>
@stop
