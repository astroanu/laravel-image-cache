<?php namespace Astroanu\ImageCache;

use Illuminate\Support\ServiceProvider;

class ImageCacheProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Astroanu\ImageCache'
		);
	}

	/**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

		$this->publishes([
		    __DIR__ . '/../config/imagecache.php' => config_path('astroanu/imagecache.php')
		], 'config');

		include __DIR__ . '/../routes.php';
    }
}
