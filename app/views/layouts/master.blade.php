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
	<div class="container">
		<div class="header">
		@include('nav')
		</div>

		@section('content')
		@show

		<div class="footer">
			<p>&copy; <a href='http://james-brooks.uk'>James Brooks</a> {{ date('Y') }}</p>
		</div>
	</div>
</body>
</html>