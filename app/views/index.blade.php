@extends('layouts.master')

@section('content')
<section id="intro" class="intro-section">
	<div class='container'>
		<div class='row hero-section'>
			<h1>PHP Code Checking</h1>
			<p>Get your PHP pull requests checked on.</p>

			<a class="btn btn-green btn-outline-light" href="/auth/github"><i class='fa fa-github'></i>  Sign in with GitHub</a>

			<div class="row">
				<div class='col-md-12'>
					<img src="/images/main_laptop.png" class="img-responsive hero-section-laptop" />
				</div>
			</div>
		</div>
	</div>
</section>

<section id="sectionone" class="features-section">
	<div class="container">
		<div class='row'>
			<div class='col-md-12'>
				<ul class'list-unstyled'>
					<li>
						<h2>Activate Repos</h2>
						<p>Tell Anorak which repositories to watch.</p>
					</li>
					<li>
						<h2>Commit &amp; Pull Request</h2>
						<p>Commit your code and create a new pull request. Anorak will automatically review your code.</p>
					</li>
					<li>
						<h2>Comment</h2>
						<p>The changed files are commented on to expose any violations against your code standards.</p>
						<figure>
							<img src='/images/screens/comments.png' />
						</figure>
					</li>
					<li>
						<h2>Anorak for other SCM's?</h2>
						<p>Send me a tweet <a href='https://twitter.com/jbrooksuk'>@jbrooksuk</a>!</p>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
@stop