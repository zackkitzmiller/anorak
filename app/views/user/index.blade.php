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
			<div class='col-md-6 col-md-offset-3'>
				<div class='repo-listing' repo-list=''></div>
			</div>
		</div>
	</div>
</section>
@include('user.templates')
@stop
