<?php defined('SYSPATH') OR die('No direct access allowed.');

class Furi_Core {

	public static function factory()
	{
		if ( function_exists('curl_init') )
		{
			return new FuriCurl();
		}
		else
		{
			return new FuriStream();
		}
	}

} // End of fURI Library