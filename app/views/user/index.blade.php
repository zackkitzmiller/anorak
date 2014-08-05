@extends('layouts.master')

@section('content')
<h1>Anorak<small>CI</small></h1>

<p>Hey <a href='https://github.com/{{ Auth::getUser()->github_username }}'>{{ Auth::getUser()->github_username }}</a>. <a href='/user/logout'>Logout</a>.</p>

<h1>Getting started</h1>
<p>To get started, activate a repository. Then create a new <code>.anorak.yml</code> file to the root of your directory.</p>

<ul>
	@forelse(Auth::user()->repos as $Repo)
	<li><a href='/repo/{{ $Repo->id }}/{{ $Repo->active ? "deactivate" : "activate" }}'>{{ $Repo->full_github_name }}</a> &mdash; ({{ $Repo->active ? "Active" : "Inactive" }})</li>
	@empty
	<li>Repo's need synchronising. If you've just signed up to Anorak, refresh in a few seconds.</li>
	@endforelse
</ul>
@stop