<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Steam fURI Driver
 * 
 * @package  fURI
 * @author   Beau Dacious <beau@cxzcxz.com>
 */
class Furi_Stream_Driver extends Furi_Driver {
	
	// Stream context options
	protected $options = array(
		'http' => array(
			'method' => 'GET',
		)
	);
	
/* ----------------------------------------------------------------------------
	Interface Methods
---------------------------------------------------------------------------- */
	
	public function get($uri)
	{
		$context = stream_context_create($this->options);
		$handle = fopen($uri, 'rb', FALSE, $context);
		
		$content = stream_get_contents($handle);
		
		fclose($handle);
		
		return $content;
	}

} // End Furi_Stream_Driver