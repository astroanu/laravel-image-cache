<?php 

if(Config::get('imagecache.imagepath') == 'images'){
	Route::get('/images/{folder}/{file}-{width?}-{height?}.{ext?}', '\Astroanu\ImageCache\ImageCacheController@index');
}