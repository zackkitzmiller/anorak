@extends('layouts.master')

@section('content')
<section class=''>
	<div class="container">
		<div class="row centered">
			<h1>Register for updates</h1>
			<hr class="aligncenter mb">
			<p class="lead">We're not quite ready to open yet so sign up for our newsletter and we'll keep you up to date with the latest Anorak news.</p>
			<div class="col-md-6 col-md-offset-3">
				<form role="form" action="//anorakci.us9.list-manage.com/subscribe/post?u=ddd8a158582080105308f31b9&amp;id=393211c960" method="post" enctype="plain" class='signup-form'> 
					<input type="email" name="EMAIL" class="subscribe-input" placeholder="Enter your e-mail address..." required>
					<button class='btn btn-submit subscribe-submit' type="submit">Subscribe</button>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="grey">  
	<div class="container">
		<div class="row mtb centered">
			<div class="col-md-3">
				<div class="circle-icon">
					<i class="fa fa-github"></i>
				</div>
				<h3>GitHub</h3>
				<p>Signing up takes two clicks. It's really fast to get started with Anorak!</p>
			</div>

			<div class="col-md-3">
				<div class="circle-icon">
					<i class="fa fa-lightbulb-o"></i>
				</div>
				<h3>Activate a repository</h3>
				<p>Click on the name of the repository that you'd like to activate Anorak on.</p>
			</div>
			<div class="col-md-3">
				<div class="circle-icon">
					<i class="fa fa-code"></i>
				</div>
				<h3>Commit code</h3>
				<p>Make your changes and commit your code.</p>
			</div>
			<div class="col-md-3">
				<div class="circle-icon">
					<i class="fa fa-mail-forward"></i>
				</div>
				<h3>Pull request</h3>
				<p>Open a Pull Request and Anorak will do the rest for you.</p>
			</div>
		</div>
	</div>
</section>

<div class="container">
	<div class="row mtb2">
		<h1 class="centered">Using Anorak</h1>
		<hr class="aligncenter mb">
		
		<div class="col-md-5 hidden-xs">
			<!-- <img class="img-responsive aligncenter" src="/images/Anorak.png"> -->
			<div class='example'>
				<div class="command">
					<label>.anorak.yml</label>
				</div>
				<div class="code">
					<pre><code>standards: "PSR1"
file:
	lineEndings: "\n"

line:
	maxLength: 80</code></pre>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="features f-l">
				<h3>Good standards by default</h3>
				<p>By default, Anorak uses PSR-1 as a standard. Don't worry though, you can override the default with one line of code.</p>
			</div>
			<div class="features f-l">
				<h3>Override individual settings</h3>
				<p>Love a standard, but hate just one part? No problem, Anorak allows you to set your own individual settings.</p>
			</div>
		</div>
		
	</div>
</div>

<section class='grey pricing'>
	<div class="container">
		<div class="row mtb">
		<div class="col-md-4">
				<div class="price">
					<h5>Personal Public</h5>
					<h1>Free</h1>
					<h6></h6>
					<p class="mt">
						If your repository is public, it's free!
					</p>
					{{-- <p class="mt"><button class="btn btn-lg btn-green">Buy It Now!</button></p> --}}
				</div>
			</div>

			<div class="col-md-4">
				<div class="price">
					<h5>Private Personal</h5>
					<h1>$5</h1>
					<h6>each per month</h6>
					<p class="mt">
						Designed for private personal repositories.
					</p>
					{{-- <p class="mt"><button class="btn btn-lg btn-green">Buy It Now!</button></p> --}}
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="price">
					<h5>Private Organisation</h5>
					<h1>$15</h1>
					<h6>each per month</h6>
					<p class="mt">
						For the private organisational repositories.<br />
						<small><em>Not-for-profit can benefit from free repos, just talk to us!</em></small>
					</p>
					{{-- <p class="mt"><button class="btn btn-lg btn-green">Buy It Now!</button></p> --}}
				</div>
			</div>
		</div>
	</div>
</section>

<section class="testimonials">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 centered">
				<div class="item active">
					<h1 class='mb'>Built by</h1>
					<img src="https://gravatar.com/avatar/{{ md5('jbrooksuk@me.com') }}.png" class="img-circle aligncenter" width="120" alt="First slide">
					<h3>James Brooks</h3>
					<hr class="aligncenter">
				</div>
			</div>
		</div>
	</div>
</section>
@stop