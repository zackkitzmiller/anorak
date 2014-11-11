@extends('layouts.page')

@section('content')
<section id="sectionone" class="features-section">
	<div class="container">
		<div class='row'>
			<div class='col-md-12 section-head'>
				<h1>Getting started</h1>
				<p class='lead'>Setting up with Anorak takes only a matter of minutes.</p>
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
				<p class='lead'>Keeping code consistent when there are multiple developers working on it can be hard. Employing standards can help this, by making everyone aware of how you expect code changes to be carried out.</p>

				<p class='lead'>If you're happy with one of the default standards below you can simply add <code>standards: "zend"</code> to the top of your configuration file.</p>

				<div class='row'>
					<div class='col-md-6'>
						<h3>PSR</h3>
						<p>See more about the PSR set of standards at <a href='http://www.php-fig.org'>PHP-FIG.org</a></p>
					</div>
					<div class='col-md-6'>
						<h3>Zend</h3>
						<p>The Zend Frameworks uses its own set of standards. Find out more at <a href='http://framework.zend.com/manual/1.10/en/coding-standard.html'>framework.zend.com</a></p>
					</div>
				</div>
				<div class='row'>
					<div class='col-md-6'>
						<h3>Codeigniter</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
					<div class='col-md-6'>
						<h3>PEAR</h3>
						<p>Some kind of description regarding the standard?</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
