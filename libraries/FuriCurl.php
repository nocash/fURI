<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @todo test switching back and forth between GET and POST
 * @todo add support for multi handles?
 * @todo add support for cookie file
 */
class FuriCurl_Core extends FuriAbstract implements FuriInterface {

	private $ch;
	private $headers = array();
	private $method = '';
	private $postdata = '';

	public function __construct()
	{
		$this->ch = $this->init();
		parent::__construct();
	}

	public function __destruct()
	{
		$this->close();
	}

/* ----------------------------------------------------------------------------
	Interface Methods
---------------------------------------------------------------------------- */

	public function data($data)
	{
		// Only string or array is supported by the CURLOPT_POSTDATA option
		if ( ! is_string($data) && ! is_array($data) )
		{
			// If it's an object we can probably convert it
			if ( is_object($data) )
			{
				$data = (array) $data;
			}
			else
			{
				// @todo add error handling
			}
		}

		// Store data until we're sure we know the request method
		$this->postdata = $data;

		// Method chaining
		return $this;
	}

	public function method($method)
	{
		// Only deal with uppercase method names
		$method = strtoupper($method);

		switch ( $method )
		{
			case 'GET':

				$this->setopt(CURLOPT_HTTPGET, TRUE);
				break;

			case 'POST':

				$this->setopt(CURLOPT_POST, TRUE);
				break;

			case 'PUT':

				$this->setopt(CURLOPT_PUT, TRUE);
				break;

			// DELETE and other methods are unsupported by cURL
			case 'DELETE':
			default:

				// Use cURL's custom request option to pull it off
				$this->setopt(CURLOPT_CUSTOMREQUEST, $method);
				break;
		}

		return $this; // For method chaining
	}

	public function request($url)
	{
		$this->setopt(CURLOPT_URL, $url);
		$this->apply_headers();

		return $this->exec();
	}

	public function set_header($header)
	{
		$this->headers[] = $header;
	}

	public function set_option($option, $value)
	{
		// Convert fURI option to cURL constant name
		$curlopt = 'CURLOPT_' . strtoupper($option);

		if ( defined($curlopt) )
		{
			return $this->setopt(constant($curlopt), $value);
		}
	}

/* ----------------------------------------------------------------------------
	Class-Specific Methods
---------------------------------------------------------------------------- */

	private function apply_headers()
	{
		$this->setopt(CURLOPT_HTTPHEADER, $this->headers);
	}

/* ----------------------------------------------------------------------------
	cURL Wrapper Methods
---------------------------------------------------------------------------- */

	private function close()
	{
		return curl_close($this->ch);
	}

	private function copy_handle()
	{
		return curl_copy_handle($this->ch);
	}

	private function error()
	{
		return curl_error($this->ch);
	}

	private function errorno()
	{
		return curl_errno($this->ch);
	}

	private function exec()
	{
		return curl_exec($this->ch);
	}

	private function getinfo($option = 0)
	{
		return curl_getinfo($this->ch, $option);
	}

	private function init($url = NULL)
	{
		return curl_init($url);
	}

	private function setopt($option, $value)
	{
		return curl_setopt($this->ch, $option, $value);
	}

	private function setopt_array($options)
	{
		return curl_setopt_array($this->ch, $options);
	}

	private function version($age = CURLVERSION_NOW)
	{
		return curl_version($age);
	}

} // End FuriCurl_Core