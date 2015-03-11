<?php 

Route::get('/' . Config::get('astroanu.imagecache.imagepath') . '/{folder}/{file}-{width?}-{height?}.{ext?}', 
		'\Astroanu\ImageCache\ImageCacheController@index');