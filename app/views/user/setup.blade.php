@extends('layouts.master')

@section('content')
<section id="sectionone" class="features-section">
	<div class="container">
		<div class='row'>
			<div class='col-md-12 section-head'>
				<h1>Getting started</h1>
				<p>Getting started is as simple as adding one file to your codebase!</p>
				<ol>
					<li>Create a new file in the root of your projects directory named <code>.anorak.yml</code> with the content of: <code>standard: "PSR2"</code> (see below for valid standards)</li>
					<li>The file should then be committed and pushed before Anorak is activated.</li>
					<li>Activate a repository.</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section id='sectiontwo' class='features-section section-colored'>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h1>Check code against leading standards</h1>
				<p class='ldead'>Currently Anorak uses <code>PHP_CodeSniffer</code> (likely to change) to find code violations. This means that Anorak is able to run standards against:</p>

				<div class='row'>
					<div class='col-md-6'>
						<h3>PSR1</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
					<div class='col-md-6'>
						<h3>PSR2</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-6'>
						<h3>Zend</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
					<div class='col-md-6'>
						<h3>PEAR</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-6'>
						<h3>Generic</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
					<div class='col-md-6'>
						<h3>PHPCS</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop