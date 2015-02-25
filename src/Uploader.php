<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class Uploader {

	public static function upload($file, $imagesdir)
	{
		$fileName = md5(microtime() . '_imagecache');

		$extention = $file->getClientOriginalExtension(); 
		$fileName = $fileName . '.' . $extention;

		$destDir = Config::get('imagecache.paths.input') . '/'. $imagesdir;

		if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir);
        }

		$image = $file->move($destDir, $fileName);

		return $image;
	}
}