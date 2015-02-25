<?php

return 	array(
	'paths' => array(
        'input' => '../storage/assets',
        'output' => '../storage/imagecache'
    ),
    'imagedriver' => 'imagick',
    'imagepath' => 'images',
    'defaults' => array(
        'thumbwidth' => 80,
        'thumbheight' => 80,
        'jpgquality' => 80
    ),
);