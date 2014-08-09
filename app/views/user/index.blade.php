@extends('layouts.master')

@section('content')
<div class='panel panel-default'>
	<div class='panel-heading'>
		Repositories
	</div>
	<div class='panel-body'>
	@if(Auth::user()->repos()->count() === 0)
		<p>Your repositories may still be syncing.</p>
		<p>If you've just signed up to Anorak, refresh in a few seconds.</p>
	@else
		<p class='text-danger'>Anorak is still in beta and as such, may not always be responsive.</p>
	@endif
	</div>
	<ul class='list-group'>
		@forelse(Auth::user()->repos()->orderBy('full_github_name')->get() as $Repo)
		<li class='list-group-item {{ $Repo->active ? "active" : "inactive" }}'><i class='fa {{ $Repo->private ? "fa-lock" : "fa-unlock" }}'></i> <a href='/repo/{{ $Repo->id }}/{{ $Repo->active ? "deactivate" : "activate" }}'>{{ $Repo->full_github_name }}</a></li>
		@empty
		@endforelse
	</ul>
</div>
@stop