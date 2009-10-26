<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Remote content fetching library.
 * 
 * @package  fURI
 * @author   Beau Dacious <beau@cxzcxz.com>
 */
class Furi_Core {
	
	// Configuration
	protected $config;
	
	// Driver
	protected $driver;
	
	/**
	 * Create an instance of fURI.
	 * 
	 * @return  object
	 */
	public static function factory($config = array())
	{
		return new Furi($config);
	}
	
	/**
	 * Return a static instance of fURI.
	 * 
	 * @return  object
	 */
	public static function instance($config = array())
	{
		static $instance;
		
		// Load the fURI instance
		empty($instance) and $instance = new Furi($config);
		
		return $instance;
	}

	public function __construct($config = array())
	{
		// Append default fURI configuration
		$config += Kohana::config('furi');
		
		// Check for 'auto' driver and adjust configuration
		if ( strtolower($config['driver'] == 'auto') )
		{
			if ( function_exists('curl_init') )
			{
				$config['driver'] = 'cURL';
			}
			else
			{
				$config['driver'] = 'Stream';
			}
		}
		
		// Save the config in the object
		$this->config = $config;
		
		// Set the driver class name
		$driver = 'Furi_'.$config['driver'].'_Driver';
		
		if ( ! Kohana::auto_load($driver) )
		{
			throw new Kohana_Exception('core.driver_not_found', $config['driver'], get_class($this));
		}
		
		// Load the driver
		$driver = new $driver($config);

		if ( ! ($driver instanceof Furi_Driver) )
		{
			throw new Kohana_Exception('core.driver_implements', $config['driver'], get_class($this), 'Furi_Driver');
		}

		// Load the driver for access
		$this->driver = $driver;

		Kohana::log('debug', 'Furi Library loaded');
	}
	
	public function get($uri)
	{
		return $this->driver->get($uri);
	}
	
	public function post($uri, $data)
	{
		if ( ! is_array($data) )
		{
			if ( is_string($data) )
			{
				$query = $data;
				$data = array();
				
				parse_str($query, $data);
			}
			elseif ( is_object($data) )
			{
				$data = (array) $data;
			}
			else
			{
				// Unsupported type
				return FALSE;
			}
		}
		
		return $this->driver->post($uri, $data);
	}

} // End Furi_Core