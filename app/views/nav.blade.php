<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header page-scroll">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand" href="/">Anorak</a>
		</div>

		@if(Auth::check())
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a href="/user">Repositories</a></li>
				<li><a href="/user/setup">Setup</a></li>
				<li><a href="/user/account">My Account</a></li>
			</ul>
		</div>
		@endif
	</div>
</nav>
