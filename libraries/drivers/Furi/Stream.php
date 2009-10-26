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
		$this->options['http']['method'] = 'GET';
		
		$context = stream_context_create($this->options);
		$handle = fopen($uri, 'rb', FALSE, $context);
		$content = stream_get_contents($handle);
		fclose($handle);
		
		return $content;
	}
	
	/**
	 * Perform a POST request.
	 * 
	 * @todo should also support POSTing files
	 * 
	 * @param $uri
	 * @param $data
	 */
	public function post($uri, $data)
	{
		$this->options['http']['method'] = 'POST';
		$this->options['http']['header'] = 'Content-Type: application/x-www-form-urlencoded';
		$this->options['http']['content'] = http_build_query($data);
		
		$context = stream_context_create($this->options);
		$handle = fopen($uri, 'rb', FALSE, $context);
		$content = stream_get_contents($handle);
		fclose($handle);
		
		return $content;
	}

} // End Furi_Stream_Driver