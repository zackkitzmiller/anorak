@extends('layouts.master')

@section('content')
<h1>Anorak</h1>

<p>Hey {{ Auth::getUser()->github_username }}. <a href='/user/logout'>Logout</a>.</p>
@stop