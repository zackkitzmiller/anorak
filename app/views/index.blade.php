@extends('layouts.master')

@section('content')
<h1>Anorak<small>CI</small></h1>

@if(Auth::check())
<a href='/user'>Account</a>
@else
<a href='/auth/github'>Signin with GitHub</a>
@endif
<p>Copyright &copy; <a href='http://james-brooks.uk'>James Brooks</a>, @jbrooksuk {{ date('Y') }}</p>

@stop