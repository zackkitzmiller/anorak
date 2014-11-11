<li class='list-group-item'>
	<div class='row'>
		<div class='col-lg-8'>
			@if($Repo->private)<i class='fa fa-lock'></i>@endif {{ $Repo->full_github_name }}
		</div>
		<div class='col-lg-4 repo-name'>
			<?php $Active = $Repo->active; ?>
			<button type='submit' class='btn btn-{{ $Active ? "danger" : "trans" }} pull-right' name='repo' data-action="{{ $Active ? 'deactivate' : 'activate' }}" data-repoid='{{ $Repo->id }}'>{{ $Active ? "Deactivate" : "Activate" }}</button>
		</div>
	</div>
</li>
