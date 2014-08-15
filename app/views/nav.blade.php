<img src='/images/AnorakFull.png' class='logo' alt='Anorak' />
<ul class="nav nav-pills pull-right">
	@if(Auth::check())
	<li><a href="/user">Repositories</a></li>
	<li><a href="/user/setup">Setup</a></li>
	@else
	<li class='login-btn'><a class="btn btn-lg btn-green" href="/auth/github" role="button"><i class='fa fa-github'></i> Sign in with GitHub</a></li>
	@endif
</ul>