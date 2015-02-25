<?php 

if(Config::get('imagecache.imagepath') == 'images'){
	Route::get('/' . Config::get('imagecache.imagepath') . '/{folder}/{file}-{width?}-{height?}.{ext?}', 
		'\Astroanu\ImageCache\ImageCacheController@index');
}