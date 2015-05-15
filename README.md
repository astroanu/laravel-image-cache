## Laravel ImageCache
### Install
Add this to your composer and run ```composer update```

    "astroanu/laravel-image-cache": "dev-master"

### Loading Provider
Add this to ````config/app.php````

   	'providers' => [
   	   	   	 ...
   	   	   	'Astroanu\ImageCache\ImageCacheProvider'
   	    ];

### The config file
Run ````artisan vendor:publish```` to copy the config file.

    php artisan vendor:publish
 
 Sample config file:   
    
    return 	array(
        'paths' => array(
            'input' => '../storage/assets', //this is where we will upload images. Also supports Laravel 5 file system.. see below
            'output' => '../storage/imagecache' // this is where we will save cached images. You are free to clean this folder when needed. Also supports Laravel 5 file system.. see below
        ),
        'usestorage' => true, // wheather to use Laravel filesystem or not.. see below.
        'imagedriver' => 'imagick', // imagick or gd
        'imagepath' => 'images', // default route for images.
        'defaults' => array(
        	'thumbwidth' => 80, // default thumb size
        	'thumbheight' => 80, // default thumb size
        	'jpgquality' => 80, // default jpg quality
        )
    );

### Using Laravel FileSystem

The image cache can be used with [Laravel 5 file system](http://laravel.com/docs/5.0/filesystem) enabling you to save your images right in to the cloud or the local file system based on your /config/filesystem.php configuration. 

To set up Laravel file system turn 'usestorage' => true on the config file.
Define the input and output disks on the config/filesystem.php


    'disks' => [

        'img_cache_input' => [
            'driver' => 'local',
            'root'   => storage_path().'/app/imagecache/input',
        ],
        'img_cache_output' => [
            'driver' => 'local',
            'root'   => storage_path().'/app/imagecache/output',
        ],

        'local' => [
            'driver' => 'local',
            'root'   => storage_path().'/app',
        ],

Then define the same disk ids in the config/astroanu/imagecache.php

    return  array(
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

### Image routes
The following image urls/routes are available:

    /{route}/{folder}/{image id}.{extention} // full image
    /{route}/{folder}/{image id}-{width}-{height}.{extention} // resized and cropped
    
### Using Traits
You may use the Trait ````\Astroanu\ImageCache\Traits\GetImage```` inside your model. Simply put:

    class Users extends Model {
        // this is required. this is where we look for the image file. see uploading.
        protected $imagesdir = 'avatars';  
        use \Astroanu\ImageCache\Traits\GetImage;
    }
    
Then in your view or controller:

    echo User::find(1)->getImage(); // returns the cached image url
    
getImage() supports the followign parameters:

    getImage() //  returns the default thumb size: as defined in the config
    getImage(50) // returns a cropped and resized square image 
    getImage(50, 800) // returns a cropped and resized rectangular image 

### Uploading images

To upload images use ````Astroanu\ImageCache\Uploader````;

    use Astroanu\ImageCache\Uploader;
    
    class Users extends Model {
    
        // this is required. this is we save the uploaded files.
        protected $imagesdir = 'avatars';  
        
        public function uploadAndSetAvatar($file)
    	{
    		if (!is_null($file)) {		
    		    // here we are saving the returned image id to the model's image attribute
    			$this->image = Uploader::upload($file, $this->imagesdir); 
    		}
    	}
    }
    
And in the controller simply:

    $user = new User();
    $user->uploadAndSetAvatar(Input::file('image'));
    $user->save();
