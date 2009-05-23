<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @todo test switching back and forth between GET and POST
 */
class FuriCurl_Core extends FuriAbstract implements FuriInterface {

	private $resource;

	public function __construct($url = NULL)
	{
		$this->resource = $this->init($url);
	}

	public function __destruct()
	{
		$this->close();
	}

// ============================================================================

	public function get($url = NULL)
	{
		$this->setopt(CURLOPT_HTTPGET, TRUE);
		return $this->exec();
	}

	public function post($url = NULL)
	{
		$this->setopt(CURLOPT_POST, TRUE);
		return $this->exec();
	}

	public function put($url = NULL)
	{
		$this->setopt(CURLOPT_PUT, TRUE);
		return $this->exec();
	}

	public function delete($url = NULL)
	{
		$this->setopt(CURLOPT_CUSTOMREQUEST, 'DELETE');
		return $this->exec();
	}

	// @todo move to abstract?
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

	// @todo move to abstract?
	public function copy_headers()
	{
		foreach ( $_SERVER as $key => $value )
		{
			if ( 'HTTP_' == substr($key, 0, 5) )
			{
				$key =	ucwords(
							strtolower(
								str_replace('_', '-',
									str_replace('HTTP_', '', $key)
								)
							)
						);

				if ( $key != 'Cookie' )
				{
					$this->set_header($key . ': ' . $value);
				}
			}
		}
	}

	// @todo write function
	public function get_headers()
	{
		// Not yet implemented; see CURLOPT_HEADERFUNCTION in PHP manual.
	}

	// @todo Allow option specification?
	public function get_info()
	{
		return $this->getinfo();
	}

	// @todo write function; options will need to be stored in a temp array
	public function get_options()
	{
		// Not yet implemented
	}

	public function set_header($header)
	{
		// Not yet implemented
	}

	public function set_option($option, $value)
	{
		$this->setopt($option, $value);
	}

	public function set_options($options)
	{
		$this->setopt_array($options);
	}

// ============================================================================

	public function close()
	{
		return curl_close($this->resource);
	}

	public function error()
	{
		return curl_error($this->resource);
	}

	public function errorno()
	{
		return curl_errno($this->resource);
	}

	public function exec()
	{
		return curl_exec($this->resource);
	}

	public function getinfo($option = 0)
	{
		return curl_getinfo($this->resource, $option);
	}

	public function init($url = NULL)
	{
		return curl_init($url);
	}

	public function setopt($option, $value)
	{
		return curl_setopt($this->resource, $option, $value);
	}

	public function setopt_array($options)
	{
		return curl_setopt_array($this->resource, $options);
	}

} // End of fURI cURL Library