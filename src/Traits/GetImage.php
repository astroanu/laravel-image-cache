<?php namespace Astroanu\ImageCache\Traits;

use Config;

trait GetImage {

    public function getImage() 
    {
    	$width = Config::get('astroanu.imagecache.defaults.thumbwidth');
    	$height = Config::get('astroanu.imagecache.defaults.thumbheight');

    	if(func_num_args() == 1){

    		$width = $height = func_get_arg(0);

    	}elseif(func_num_args() == 2){

    		$width = func_get_arg(0);
    		$height = func_get_arg(1);

    	}

        $file = pathinfo($this->image, PATHINFO_FILENAME );
		$ext = pathinfo($this->image, PATHINFO_EXTENSION);

		return '/' . Config::get('astroanu.imagecache.imagepath') . '/' . $this->imagesdir . '/' 
                . $file . '-' . $width . '-' . $height . '.' . $ext;
    }
}