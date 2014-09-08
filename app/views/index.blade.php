@extends('layouts.master')

@section('content')
<section id="intro" class="intro-section">
	<div class='container'>
		<div class='hero-section'>
			<h1>Keep your Pull Requests up to standard!</h1>

			{{--@if(!Auth::check())
			<a class="btn btn-green btn-outline-light" href="/auth/github"><i class='fa fa-github'></i>  Sign in with GitHub</a>
			@endif--}}

			<div class='row'>
				<div class='col-lg-3'></div>
				<div class='col-lg-6'>
					<form action="//anorakci.us9.list-manage.com/subscribe/post?u=ddd8a158582080105308f31b9&amp;id=393211c960" method="post" name="mc-embedded-subscribe-form" class="form-horizontal col-lg-12" target="_blank" novalidate role='form'>
						<div class='form-group form-group-lg'>
							<input type="email" value="" name="EMAIL" class="form-control" placeholder="Your email address" required>
						</div>
					    <div style="position: absolute; left: -5000px;">
					    	<input type="text" name="b_ddd8a158582080105308f31b9_393211c960" tabindex="-1" value="">
					    </div>
					    <button type='submit' name='subscribe' class='btn btn-green btn-outline-light'>Register interest</button>
					</form>
				</div>
				<div class='col-lg-3'></div>
			</div>

			<div class="row">
				<div class='col-lg-1'></div>
				<div class='col-lg-10'>
					<img src="/images/main_laptop.png" class="img-responsive hero-section-laptop" />
				</div>
				<div class='col-lg-1'></div>
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
						<h3>Sign up</h3>
						<p>Signing up takes two clicks. It's really fast to get started with Anorak!</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-lightbulb-o'></i></h1>
						<h3>Activate a Repository</h3>
						<p>Click on the name of the repository that you'd like to activate Anorak on.</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-code'></i></h1>
						<h3>Commit code</h3>
						<p>Make changes to the codebase in a different branch, as you usually would.</p>
					</div>
					<div class='col-md-3'>
						<h1><i class='fa fa-mail-forward'></i></h1>
						<h3>Pull Request</h3>
						<p>Open a Pull Request and Anorak will do the rest for you.</p>
					</div>
				</div>
			</div>
		</div>

		@if(!Auth::check())
		<div class='row'>
			<div class='col-md-12 text-center'>
				<a class="btn btn-green btn-outline-light" href="/auth/github"><i class='fa fa-github'></i>  Sign in with GitHub</a>
			</div>
		</div>
		@endif
	</div>
</section>
@stop