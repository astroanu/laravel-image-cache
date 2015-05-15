<?php

return 	array(
    'paths' => array(
        'input' => 'img_cache_input',
        'output' => 'img_cache_output',
    ),
    'usestorage' => true,
    'imagedriver' => 'imagick',
    'imagepath' => 'images',
    'defaults' => array(
        'thumbwidth' => 80,
        'thumbheight' => 80,
        'jpgquality' => 80
    ),
);