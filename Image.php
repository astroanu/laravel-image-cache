<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class Image {

    protected $imagine;
    protected $library = false;
    protected $fodler;
    protected $filename;
    protected $outputFile;

    public function __construct($folder, $filename)
    {
        $this->folder = $folder;
        $this->filename = $filename;
        
        if (!$this->imagine)  {
            if (!$this->library and class_exists('Imagick')) {
                $this->imagine = new \Imagine\Imagick\Imagine();
            } else {
                $this->imagine = new \Imagine\Gd\Imagine();
            }
        }
    }

    public function resize($width, $height) 
    {

        $outputDir = Config::get('assets.images.paths.output') . '/' . $this->folder;
        $inputDir = Config::get('assets.images.paths.input') . '/' . $this->folder;

        $inputFile = $inputDir . '/' . $this->filename;

        if (!file_exists($inputFile)) {
            return false;
        }

        if (is_null($width) || is_null($height)) {
            $this->outputFile = $inputFile;
            return $this->imagine->open($inputFile)->show('jpg');
        }

        $this->outputFile = $outputDir . '/' . $width . '-' . $height . '_' . $this->filename;

        if (File::isFile($this->outputFile)) {
            return $this->imagine->open($this->outputFile)->show('jpg');
        }

        $size = new \Imagine\Image\Box($width, $height);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        if (!File::isDirectory($outputDir)) {
            File::makeDirectory($outputDir);
        }

        return $this->imagine->open($inputFile)
            ->thumbnail($size, $mode)
            ->save($this->outputFile, array('quality' => 80))
            ->show('jpg');

    }

    public function getMimeType() 
    {
        $imagetype = exif_imagetype($this->outputFile);
        if($imagetype){
            return image_type_to_mime_type($imagetype);
        }
        return 'image/jpeg';
    }

    public function getFileSize() 
    {
        return filesize($this->outputFile);
    }
}