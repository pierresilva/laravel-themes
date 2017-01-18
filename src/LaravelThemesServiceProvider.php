<?php
namespace pierresilva\LaravelThemes;

use Illuminate\Support\ServiceProvider;
use pierresilva\LaravelThemes\Providers\HelperServiceProvider;

class LaravelThemesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the service provider.
	 *
	 * @return null
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../config/laravel-themes.php' => config_path('laravel-themes.php')
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
		    __DIR__.'/../config/laravel-themes.php', 'themes'
		);

		$this->app->register(HelperServiceProvider::class);

		$this->commands(
            'pierresilva\LaravelThemes\Console\Generators\GenerateThemeCommand'
        );

		$this->registerServices();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return ['themes'];
	}

	/**
	 * Register the package services.
	 *
	 * @return void
	 */
	protected function registerServices()
	{
		$this->app->singleton('themes', function($app) {
			return new LaravelThemes($app['files'], $app['config'], $app['view']);
		});

		$this->app->booting(function($app) {
			$app['themes']->register();
		});		
	}
}
