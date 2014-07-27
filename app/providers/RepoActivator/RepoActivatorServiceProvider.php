<?php 

	namespace Anorak\RepoActivator;

	use Illuminate\Support\ServiceProvider;

	class RepoActivatorServiceProvider extends ServiceProvider {
		public function register() {
			$this->app['repoactivator'] = $this->app->share(function($app) {
				return new RepoActivator;
			});

			$this->app->booting(function() {
				$Loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$Loader->alias('RepoActivator', 'Anorak\RepoActivator\Facades\RepoActivator');
			});
		}
	}