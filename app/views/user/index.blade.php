@extends('layouts.master')

@section('content')
<h1>Anorak</h1>

<p>Hey {{ Auth::getUser()->github_username }}. <a href='/user/logout'>Logout</a>.</p>

<ul>
@forelse(Auth::user()->repos as $Repo)
<li><a href='/repo/{{ $Repo->id }}/{{ $Repo->active ? "deactivate" : "activate" }}'>{{ $Repo->full_github_name }}</a></li>
@empty
<li>Sync repos?</li>
@endforelse
</ul>
@stop