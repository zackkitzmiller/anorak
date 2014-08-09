@extends('layouts.master')

@section('content')
<h2>Review your PHP code with inline comments! <span class='label label-info'>BETA</span></h2>

<ol class='getting-started'>
	<li class='step count'>
		<h3>Activate Repos</h3>
		<p>Tell Anorak which repositories to watch.</p>
	</li>
	<li class='step count'>
		<h3>Commit &amp; Pull Request</h3>
		<p>Commit your code and create a new pull request. Anorak will automatically review your code.</p>
	</li>
	<li class='step count'>
		<h3>Comment</h3>
		<p>The changed files are commented on to expose any violations against your code standards.</p>
		<figure>
			<img src='/images/screens/comments.png' />
		</figure>
	</li>
	<li class='step'>
		<h3>Anorak for other SCM's?</h3>
		<p>Send me a tweet <a href='https://twitter.com/jbrooksuk'>@jbrooksuk</a>!</p>
	</li>
</ol>
@stop