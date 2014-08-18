<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header page-scroll">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand" href="/">Anorak</a>
		</div>
		
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="hidden"><a href="#page-top"><i class="fa fa-arrow-up"></i></a></li>
				@if(Auth::check())
				<li><a href="/user">Repositories</a></li>
				<li><a href="/user/setup">Setup</a></li>
				@else
				<li class='login-btn'><a class="" href="/auth/github" role="button"><i class='fa fa-github'></i> Sign in with GitHub</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>