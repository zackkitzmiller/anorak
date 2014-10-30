@extends('layouts.page')

@section('content')
<section>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h1>Your repositories</h1>
				<p class='lead'><strong class="text-danger">Anorak is still in beta and as such may not always be responsive.</strong></p>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-3'></div>
			<div class='col-md-6'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<div class='row'>
							<div class='col-lg-10 col-sm-6'>
								<h3>Repositories</h3>
							</div>
							<div class='col-lg-2 col-sm-6'>
								<a href='javascript: void(0)' data-action='repo_sync' class='btn btn-info btn-lg pull-right'><i class='fa fa-refresh'></i></a>
							</div>
						</div>
					</div>
					<ul class='list-group'>
						<form name='repos'>
							@forelse(Auth::user()->repos()->orderBy('full_github_name')->get() as $Repo)
							<li class='list-group-item'>
								<div class='row'>
									<div class='col-lg-8'>
										@if($Repo->private)
										<i class='fa fa-lock'></i>
										@endif
										{{ $Repo->full_github_name }}
									</div>
									<div class='col-lg-4'>
										<?php $Active = $Repo->active; ?>
										<button type='submit' class='btn btn-{{ $Active ? "danger" : "trans" }} pull-right' name='repo' data-action="{{ $Active ? 'deactivate' : 'activate' }}" data-repoid='{{ $Repo->id }}'>{{ $Active ? "Deactivate" : "Activate" }}</button>
									</div>
								</div>
							</li>
							@empty
							<li class='list-group-item'>
								Your repositories may still be syncing. &ndash; If you've just signed up to Anorak, refresh in a few seconds
							</li>
							@endforelse
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
						</form>
					</ul>
				</div>
			</div>
			<div class='col-md-3'></div>
		</div>
	</div>
</section>
@stop
