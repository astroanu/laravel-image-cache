<?php namespace Astroanu\ImageCache;

use Response;
use File;
use Config;
use App;
use Illuminate\Routing\Controller as BaseController;

class ImageCacheController extends BaseController {

	public function index($folder, $filename, $width = null, $height = null, $ext = null)
	{
		if (!is_null($ext)) {
			$filename .= '.' . $ext;
		}

		try{

			$image = new Image($folder, $filename);

			$response = Response::make($image->resize($width, $height), 200);
			$response->header('Content-type', 'image/webp');
			return $response;

		}
		catch(\Exception $e){
			App::abort(404);
		}
	}
}
