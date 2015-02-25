<?php

return 	array(
	'paths' => array(
        'input' => '../storage/assets',
        'output' => '../storage/imagecache'
    ),
    'imagedriver' => 'imagick',
    'defaults' => array(
    	'thumbwidth' => 80,
    	'thumbheight' => 80,
	    'imagepath' => 'images',
    	'jpgquality' => 80
    )
);