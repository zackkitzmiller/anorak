@extends('layouts.master')

@section('content')
<section id='sectionone' class='features-section'>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h1>Your repositories</h1>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<div class='row'>
							<div class='col-md-10'><h3 style="margin-top: 0;">Repositories - <small>@if(Auth::user()->repos()->count() === 0)
									Your repositories may still be syncing. &ndash; If you've just signed up to Anorak, refresh in a few seconds.
									@else
									<strong class="text-danger">Anorak is still in beta and as such, may not always be responsive.</span>
									@endif</strong></h3></div>
							<div class='col-md-2'>
								<a href='javascript: void(0)' data-action='repo_sync' class='btn btn-info pull-right'><i class='fa fa-refresh'></i></a>
							</div>
						</div>
					</div>
					<ul class='list-group'>
						<form name='repos'>
							@forelse(Auth::user()->repos()->orderBy('full_github_name')->get() as $Repo)
							<li class='list-group-item'>
								<i class='fa {{ $Repo->private ? "fa-lock" : "fa-unlock" }}'></i> <a href='/repo/{{ $Repo->id }}/{{ $Repo->active ? "deactivate" : "activate" }}'>{{ $Repo->full_github_name }}</a>
								<div class='btn-group btn-group-xs pull-right'>
									<button type='button' class='btn {{ $Repo->active ? "btn-success" : "btn-default" }}' {{ $Repo->active ? "disabled" : "" }}>On</button>
									<button type='button' class='btn {{ !$Repo->active ? "btn-success" : "btn-default" }}' {{ !$Repo->active ? "disabled" : "" }}>Off</button>
								</div>
							</li>
							@empty
							@endforelse
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</form>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
@stop