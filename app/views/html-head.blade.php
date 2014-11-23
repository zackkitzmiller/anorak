<!DOCTYPE html>
<html ng-app='Anorak'>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Anorak is a continuous integration service for checking PHP code. AnorakCI automatically comments on GitHub Pull Requests.">
	<meta name="keywords" content="anorak, ci, php, github, pull request, houndci, anorakci, code, standards, service">
	<meta name="author" content="http://james-brooks.uk">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title>Anorak</title>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,700,300,600' rel='stylesheet' type='text/css'>
	<link rel='stylesheet' href='{{ elixir("css/styles.css") }}' />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/styles/github.min.css">
	<script>
		// Google Analytics
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42158883-3', 'auto');
		ga('send', 'pageview');

		// GoSquared
		!function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
		arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
		d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
		insertBefore(d,q)}(window,document,'script','_gs');
		_gs('GSN-279675-G');
	</script>
	<script src="https://js.stripe.com/v2/"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
</head>
