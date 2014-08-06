<ul class="nav nav-pills pull-right">
	@if(Auth::check())
	<li><a href="/user">Repositories</a></li>
	<li><a href="/user/setup">Setup</a></li>
	@endif
</ul>
<h3 class="text-muted"><img src='/images/AnorakFull.png' style='max-width: 400px' alt='Anorak' /></h3>