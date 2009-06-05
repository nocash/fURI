<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class FuriAbstract {

	protected $options = array();
	protected $headers = array();

	public function get($url)
	{
		return $this->method('GET')->request($url);
	}

	public function post($url)
	{
		return $this->method('POST')->request($url);
	}

	public function put($url)
	{
		return $this->method('PUT')->request($url);
	}

	public function delete($url)
	{
		return $this->method('DELETE')->request($url);
	}

	public function copy_cookies()
	{
		if ( is_array($_COOKIE) )
		{
			$cookies = array();
			foreach ( $_COOKIE as $key => $value )
			{
				$cookies[] = $key . '=' . $value;
			}

			$this->set_header('Cookie: ' . implode('; ', $cookies));
		}
	}

	// @todo unsure if/how this behaves with HTTP-X headers
	public function copy_headers()
	{
		foreach ( $_SERVER as $key => $value )
		{
			if ( 'HTTP_' == substr($key, 0, 5) )
			{
				$key = str_replace('HTTP_', '', $key);
				$key = str_replace('_', '-', $key);
				$key = strtolower($key);
				$key = ucwords($key);

				if ( $key != 'Cookie' )
				{
					$this->set_header($key . ': ' . $value);
				}
			}
		}
	}

	public function get_headers()
	{
		return $this->headers;
	}

	public function get_options()
	{
		return $this->options;
	}

	public function set_header($header)
	{
		$this->headers[] = $header;
	}

	public function set_option($option, $value)
	{
		$this->options[$option] = $value;
	}

} // End FuriAbstract