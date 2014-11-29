<script id='/templates/repo_list' type='text/ng-template'>
<div class='panel panel-default'>
	<div class='panel-heading'>
		<div class='row'>
			<div class='col-md-12'>
				<span class='label label-default'>
				Active repos:
				@{{ (repos | filter:{active: true}).length }} of @{{ repos.length }}
				</span>
				<a href='' ng-class='{disabled: syncingRepos}' ng-click='sync()'>
					<i class='fa fa-refresh'></i>
					<span>@{{ syncButtonText }}</span>
				</a>
			</div>
		</div>
		<div class='row'>
			<form class='navbar-form'>
				<div class='form-group'>
					<div class='input-group'>
						<div class='input-group-addon'>
							<i class='fa fa-search'></i>
						</div>
						<input class='form-control' ng-model='search.full_github_name' placeholder='search by repo or organization name' type='text'>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class='panel-body' ng-show='syncingRepos'>
		<div class='loading'>
			<div class='fa fa-dot'></div>
			<div class='fa fa-dot'></div>
			<div class='fa fa-dot'></div>
		</div>
	</div>
	<div class='list-group' ng-hide='syncingRepos'>
		<span class='list-group-item repo' ng-class='{active: repo.active, processing: processing}' ng-repeat='repo in repos | filter:search' repo=''></span>
	</div>
</div>
</script>

<script id='/templates/repo' type='text/ng-template'>
<a class='toggle' href='' ng-click='toggle()'>
	<span class='repo-name'><i class='fa fa-lock' ng-show='repo.private'></i> @{{ repo.full_github_name }}</span>
</a>
</script>
