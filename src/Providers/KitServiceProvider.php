<?php namespace Kit\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class KitServiceProvider extends ServiceProvider {
	/**
	 * The Artisan commands provided by starter kit.
	 *
	 * @var array
	 */
	protected $commands = [
		'Kit\Console\Commands\AppInstallCommand',
	];

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{
		// Routes
		$router->group(['namespace' => 'Kit\Http\Controllers'], function($router)
		{
			require __DIR__.'/../Http/routes.php';
		});

		// Register Assets
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'kit');
		$this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'kit');

		// Register the application command
		$this->commands($this->commands);

		// Publish the Resources
		# Migrations
		$this->publishes([
	    	__DIR__.'/../../database/migrations/' => database_path('/migrations')
		], 'migrations');

		# Seeders
		$this->publishes([
	    	__DIR__.'/../../database/seeds/' => database_path('/seeds')
		], 'seeds');

		#Configs
		$this->publishes([
	    	__DIR__.'/../../config/' => config_path()
		], 'config');

		$this->publishes([
        	__DIR__.'/../../resources/lang' => base_path('resources/lang/vendor/kit'),
    	]);	

		$this->publishes([
        	__DIR__.'/../../resources/views' => base_path('resources/views/vendor/kit'),,
    	]);	
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}