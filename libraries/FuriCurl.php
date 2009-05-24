<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @todo test switching back and forth between GET and POST
 * @todo add support for multi handles?
 * @todo add support for cookie file
 */
class FuriCurl_Core extends FuriAbstract implements FuriInterface {

	protected $resource;

	public function __construct($url = NULL)
	{
		$this->resource = $this->init($url);
	}

	public function __destruct()
	{
		$this->close();
	}

// ============================================================================

	public function method($method)
	{
		// Only deal with uppercase method names
		$method = strtoupper($method);

		switch ( $method )
		{
			case 'GET':

				$this->set_option(CURLOPT_HTTPGET, TRUE);
				break;

			case 'POST':

				$this->set_option(CURLOPT_POST, TRUE);
				break;

			case 'PUT':

				$this->set_option(CURLOPT_PUT, TRUE);
				break;

			// DELETE and other methods are unsupported by cURL
			case 'DELETE':
			default:

				// Use cURL's custom request option to pull it off
				$this->set_option(CURLOPT_CUSTOMREQUEST, $method);
				break;
		}

		return $this; // For method chaining
	}

	public function request($url)
	{
		$this->apply_headers();
		$this->apply_options();

		return $this->exec();
	}

	// @todo Allow option specification?
	public function get_info()
	{
		return $this->getinfo();
	}

// ============================================================================

	protected function apply_headers()
	{
		$this->set_option(CURLOPT_HTTPHEADER, $this->headers);
	}

	protected function apply_options()
	{
		foreach ( $this->options as $option => $value )
		{
			$this->setopt($option, $value);
		}
	}

// ============================================================================

	public function close()
	{
		return curl_close($this->resource);
	}

	public function copy_handle()
	{
		return curl_copy_handle($this->resource);
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

	public function version($age = CURLVERSION_NOW)
	{
		return curl_version($age);
	}

} // End of fURI cURL Library