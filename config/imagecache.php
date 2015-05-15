<?php

return 	array(
	'paths' => array(
        'input' => Storage::disk('cache_input'),
        'output' => Storage::disk('cache_output')
    ),
    'imagedriver' => 'imagick',
    'imagepath' => 'images',
    'defaults' => array(
        'thumbwidth' => 80,
        'thumbheight' => 80,
        'jpgquality' => 80
    ),
);