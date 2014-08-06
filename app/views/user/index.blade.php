@extends('layouts.master')

@section('content')
<div class='panel panel-default'>
	<div class='panel-heading'>
		Repositories
	</div>
	@if(Auth::user()->repos()->count() === 0)
	<div class='panel-body'>
		<p>Your repositories may still be syncing.</p>
		<p>If you've just signed up to Anorak, refresh in a few seconds.</p>
	</div>
	@endif
	<ul class='list-group'>
		@forelse(Auth::user()->repos()->orderBy('full_github_name')->get() as $Repo)
		<li class='list-group-item {{ $Repo->active ? "active" : "inactive" }}'><a href='/repo/{{ $Repo->id }}/{{ $Repo->active ? "deactivate" : "activate" }}'>{{ $Repo->full_github_name }}</a></li>
		@empty
		@endforelse
	</ul>
</div>
@stop