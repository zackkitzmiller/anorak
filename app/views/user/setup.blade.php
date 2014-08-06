@extends('layouts.master')

@section('content')
<h1>Getting started</h1>
<ol>
	<li>Create a new file in the root of your projects directory named <code>.anorak.yml</code> with the content of: <code>standard: "PSR2"</code> (see below for valid standards)</li>
	<li>The file should then be committed and pushed before Anorak is activated.</li>
	<li>Activate a repository.</li>
</ol>

<h3>Valid standards</h3>
<p>Currently Anorak uses <code>PHP_CodeSniffer</code> to find code violations. This means that Anorak is able to run standards against:</p>
<ul>
	<li>PSR1</li>
	<li>PSR2</li>
	<li>Zend</li>
	<li>PEAR</li>
	<li>Generic</li>
	<li>PHPCS</li>
	<li>Squiz</li>
</ul>

<div class='alert alert-info'>More standards will be added in the future, however it's still possible that Anorak will move away from PHP_CodeSniffer if another alternative is available.</div>
@stop