<?php 

	namespace Anorak\Tracking;

	use Illuminate\Support\ServiceProvider;

	class TrackingServiceProvider extends ServiceProvider {
		public function register() {
			$this->app['tracking'] = $this->app->share(function($app) {
				$segment = new \Segment;
				return new Tracking($segment);
			});

			$this->app->booting(function() {
				$Loader = \Illuminate\Foundation\AliasLoader::getInstance();
				$Loader->alias('Tracking', 'Anorak\Tracking\Facades\Tracking');
			});
		}
	}