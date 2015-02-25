<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class Uploader {

	public static function upload($file){
		$fileName = md5(microtime() . '_image');

		$extention = $file->getClientOriginalExtension(); 
		$fileName = $fileName . '.' . $extention;

		$image = $file ->move(Config::get('assets.images.paths.input') . '/content', $fileName);

		return $fileName;
	}
}