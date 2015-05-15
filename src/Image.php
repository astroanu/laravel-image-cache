<?php namespace Astroanu\ImageCache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Storage;

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
            if (!$this->library and class_exists('Imagick') && Config::get('astroanu.imagecache.imagedriver') == 'imagick') {
                $this->imagine = new \Imagine\Imagick\Imagine();
            } else {
                $this->imagine = new \Imagine\Gd\Imagine();
            }
        }
    }

    public function resize($width, $height) 
    {
        $useStorage = Config::get('astroanu.imagecache.usestorage');

        if ($useStorage) {
            $inputDisk = Storage::disk(Config::get('astroanu.imagecache.paths.input'));
            $outputDisk = Storage::disk(Config::get('astroanu.imagecache.paths.output'));
            
            if (!$inputDisk->exists($this->folder . '/' . $this->filename)) {
                return false;
            }    

            if (is_null($width) || is_null($height)) {
                return $this->imagine->load($inputDisk->get($this->folder . '/' . $this->filename))->show('jpg');
            }

            if ($outputDisk->exists($this->folder . '/' . $this->filename)) {
                return $this->imagine->load($outputDisk->get($this->folder . '/' . $this->filename))->show('jpg');
            }

            $size = new \Imagine\Image\Box($width, $height);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            if (!$outputDisk->exists($this->folder)) {
                $outputDisk->makeDirectory($this->folder);
            }

            $tmp = storage_path() . '\tmp_' . $this->filename;

            $this->outputFile = $this->folder . '/' . $width . '-' . $height . '_' . $this->filename;

            $tmpImage = $this->imagine->load($inputDisk->get($this->folder . '/' . $this->filename))
                ->thumbnail($size, $mode)
                ->save($tmp, array('quality' => Config::get('astroanu.imagecache.defaults.jpgquality')));

            $outputDisk->put($this->outputFile, File::get($tmp));
            unlink($tmp);

            return $this->imagine->load($outputDisk->get($this->outputFile))->show('jpg');

        } else {

            // to be removed
            $outputDir = Config::get('astroanu.imagecache.paths.output') . '/' . $this->folder;
            $inputDir = Config::get('astroanu.imagecache.paths.input') . '/' . $this->folder;

            $inputFile = $inputDir . '/' . $this->filename;

            if (!file_exists($inputFile)) {
                return false;
            }

            if (is_null($width) || is_null($height)) {
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
                ->save($this->outputFile, array('quality' => Config::get('astroanu.imagecache.defaults.jpgquality')))
                ->show('jpg');
        }

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