<?php defined('SYSPATH') OR die('No direct access allowed.');

class Furi_Core {

	public static function factory()
	{
		if ( function_exists('curl_init') )
		{
			return new FuriCurl($url);
		}
		else
		{
			return new FuriStream($url);
		}
	}

} // End of fURI Library