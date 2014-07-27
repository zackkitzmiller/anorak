<?php 

	namespace Anorak\RepoActivator\Facades;

	use Illuminate\Support\Facades\Facade;

	class RepoActivator extends Facade {
		protected static function getFacadeAccessor() {
			return 'repoactivator';
		}
	}