<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title>Anorak</title>
	<link rel='stylesheet' href='/stylesheets/css/styles.css' />
</head>
<body>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42158883-3', 'auto');
		ga('send', 'pageview');
	</script>
	<div class="container">
		<div class="header">
		@include('nav')
		</div>

		@section('content')
		@show

		<div class="footer">
			<p>Anorak is maintained by <a href='http://james-brooks.uk'>James Brooks</a>. Anorak is Copyright &copy; {{ date('Y') }} James Brooks.</p>
		</div>
	</div>
</body>
</html>