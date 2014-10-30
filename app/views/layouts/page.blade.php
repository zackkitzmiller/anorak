@include('html-head')

<body>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-42158883-3', 'auto');
		ga('send', 'pageview');
	</script>
	
	@include('nav')

	@section('content')
	@show

	{{-- @include('footer') --}}

	<script src="https://code.jquery.com/jquery-latest.min.js"></script>
	<!-- <script src="/javascripts/bootstrap.js"></script> -->
	<script src="/javascripts/app.js"></script>
</body>
</html>
