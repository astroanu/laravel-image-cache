<?php 

Route::get('/' . Config::get('imagecache.imagepath') . '/{folder}/{file}-{width?}-{height?}.{ext?}', 
		'\Astroanu\ImageCache\ImageCacheController@index');