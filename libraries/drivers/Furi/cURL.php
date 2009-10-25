<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * cURL fURI Driver
 * 
 * @todo  test switching back and forth between GET and POST
 * @todo  add support for multi handles?
 * @todo  add support for cookie file
 * 
 * @package  fURI
 * @author   Beau Dacious <beau@cxzcxz.com>
 */
class Furi_cURL_Driver extends Furi_Driver {

	// cURL handle
	protected $ch;
	
	public function __construct()
	{
		// Create a cURL handle
		$this->ch = curl_init();
		
		// Set global cURL options
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
	}

	public function __destruct()
	{
		curl_close($this->ch);
	}

/* ----------------------------------------------------------------------------
	Interface Methods
---------------------------------------------------------------------------- */

	public function get($uri)
	{
		curl_setopt($this->ch, CURLOPT_URL, $uri);
		return curl_exec($this->ch);
	}

} // End Furi_cURL_Driver