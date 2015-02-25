<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class Uploader {

	public static function upload($file, $imagesdir)
	{
		$fileName = md5(microtime() . '_imagecache');

		$extention = $file->getClientOriginalExtension(); 
		$fileName = $fileName . '.' . $extention;

		$image = $file ->move(Config::get('assets.paths.input') . '/'. $imagesdir, $fileName);

		return $fileName;
	}
}