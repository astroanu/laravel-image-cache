<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Storage;

class Uploader {

	public static function upload($file, $imagesdir)
	{
		$fileName = md5(microtime() . '_imagecache');

		$extention = $file->getClientOriginalExtension(); 
		$fileName = $fileName . '.' . $extention;

		if (Config::get('astroanu.imagecache.usestorage')){
			return self::uploadToStorage($fileName, $file, $imagesdir);
		} else {
			return self::uploadToLocal($fileName, $file, $imagesdir);
		}
	}

	private static function uploadToStorage($fileName, $file, $imagesdir)
	{
		$inputDisk = Storage::disk(Config::get('astroanu.imagecache.paths.input'));

		if (!$inputDisk->exists($imagesdir)) {
            $inputDisk->makeDirectory($imagesdir);
        }

		$inputDisk->put($imagesdir . '/' . $fileName, File::get($file));

		return $fileName;		
	}

	private static function uploadToLocal($fileName, $file, $imagesdir)
	{
		$inputDir = Config::get('astroanu.imagecache.paths.input');

		if (!File::isDirectory($inputDir)) {
            File::makeDirectory($inputDir);
        }

		$destDir = $inputDir . '/' . $imagesdir;

		if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir);
        }

		$image = $file->move($destDir, $fileName);

		return $fileName;		
	}
}