<?php namespace Astroanu\ImageCache;

trait GetImage {

    public function getImage() 
    {
    	$width = 80;
    	$height = 80;

    	if(func_num_args() == 1){
    		$width = $height = func_get_arg(0);
    	}elseif(func_num_args() == 2){
    		$width = func_get_arg(0);
    		$height = func_get_arg(1);
    	}

        $file = pathinfo($this->image, PATHINFO_FILENAME );
		$ext = pathinfo($this->image, PATHINFO_EXTENSION);

		return '/images/content/' . $file . '-'. $width . '-' . $height . '.' . $ext;
    }
}