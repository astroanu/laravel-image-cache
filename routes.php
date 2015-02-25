<?php 

Route::get('/images/{folder}/{file}-{width?}-{height?}.{ext?}', '\Astroanu\ImageCache\ImageCacheController@index');