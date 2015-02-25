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
			//$response->header('Content-Length', 'attachment; ' . $image->getFileSize());
			$response->header('Content-type', $image->getMimeType());
			return $response;

		}
		catch(\Exception $e){
			App::abort(404);
		}
		/*if ($resized === false) {
			App::abort(404);
		}

		$response = Response::make($resized, 200);
		$response->header('Content-type', $image->getMimeType($folder, $filename));

		return $response;*/
	}
}
