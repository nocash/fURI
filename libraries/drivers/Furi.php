<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Abstract fURI driver, must be extended by all drivers.
 *
 * @package  fURI
 * @author   Beau Dacious <beau@cxzcxz.com>
 */
abstract class Furi_Driver {

	abstract public function get($uri);
	
	abstract public function post($uri, $data);

} // End Furi_Driver