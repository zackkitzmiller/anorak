<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Anorak is a continuous integration service for checking PHP code">
	<meta name="keywords" content="anorak, ci, php, github, pull request, hound">
	<meta name="author" content="james-brooks.uk">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title>Anorak</title>
	<link rel='stylesheet' href='/stylesheets/css/bootstrap.css' />
	<link rel='stylesheet' href='/stylesheets/css/styles.css' />
	<link href='http://fonts.googleapis.com/css?family=Advent+Pro:400,700,300,600' rel='stylesheet' type='text/css'>
</head>

<body data-spy="scroll" data-offset="0" data-target="#theMenu">
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42158883-3', 'auto');
		ga('send', 'pageview');
	</script>
	
	@include('header')

	@section('content')
	@show

	@include('footer')

	<script src="https://code.jquery.com/jquery-latest.min.js"></script>
	<!-- <script src="/javascripts/bootstrap.js"></script> -->
	<script src="/javascripts/app.js"></script>
</body>
</html>