<?php 

Route::get('/images/{folder}/{file}-{width?}-{height?}.{ext?}', 'ImageCacheController@index');