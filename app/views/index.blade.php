@extends('layouts.master')

@section('content')
<h1>Anorak</h1>

@if(Auth::check())
<a href='/user'>Account</a>
@else
<a href='/auth/github'>Login with GitHub</a>
@endif
@stop