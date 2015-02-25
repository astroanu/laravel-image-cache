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

}
