@extends('layouts.master')

@section('content')
<section id="intro" class="intro-section">
	<div class='container'>
		<div class='row hero-section'>
			<h1>PHP Code Checking</h1>
			<p>Get your PHP pull requests checked on.</p>

			@if(!Auth::check())
			<a class="btn btn-green btn-outline-light" href="/auth/github"><i class='fa fa-github'></i>  Sign in with GitHub</a>
			@endif

			<div class="row">
				<div class='col-md-12'>
					<img src="/images/main_laptop.png" class="img-responsive hero-section-laptop" />
				</div>
			</div>
		</div>
	</div>
</section>

<section id="sectionone" class="features-section text-center">
	<div class="container">
		<div class='row'>
			<div class='col-md-12'>
				<h1>How it works</h1>
				<p class='lead'>As soon as your Pull Request is opened, Anorak will quickly check your code against the repository owners settings.</p>
				<div class='row'>
					<div class='col-md-3'>
						<h1><i class='fa fa-github'></i></h1>
						<h3>Login</h3>
						<p>Logging in takes two clicks, it's really fast to get started with Anorak!</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-lightbulb-o'></i></h1>
						<h3>Activate a Repo</h3>
						<p>Click on the name of the repository that you'd like to activate Anorak on.</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-code'></i></h1>
						<h3>Commit code</h3>
						<p>Make changes to the codebase, as you would any other project.</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-mail-forward'></i></h1>
						<h3>Pull Request</h3>
						<p>Open a Pull Request. Anorak will do the rest for you.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop