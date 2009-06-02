<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @todo test switching back and forth between GET and POST
 * @todo add support for multi handles?
 * @todo add support for cookie file
 */
class FuriCurl_Core extends FuriAbstract implements FuriInterface {

	protected $resource;

	public function __construct()
	{
		$this->resource = $this->init();
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
		$this->set_option(CURLOPT_URL, $url);

		$this->apply_headers();
		$this->apply_options();

		return $this->exec();
	}

// ============================================================================

	private function apply_headers()
	{
		$this->set_option(CURLOPT_HTTPHEADER, $this->headers);
	}

	private function apply_options()
	{
		foreach ( $this->options as $option => $value )
		{
			if ( $this->is_furi_option($option) )
			{
				$option = $this->furi_opt_to_curl($option);
			}

			$this->setopt($curlopt, $value);
		}
	}

	private function is_furi_option($option)
	{
		return ( is_string($option) && substr(strtoupper($option), 0, 5) == 'FURI_' ) ? TRUE : FALSE;
	}

	private function furi_opt_to_curl($option)
	{
		if ( $this->is_furi_option($option) )
		{
			$curlopt = str_replace('FURI_', 'CURLOPT_', strtoupper($option));
			return constant($curlopt);
		}
		else
		{
			// Option was not a fURI option to begin wtih; cannot convert
			return FALSE;
		}
	}

// ============================================================================

	private function close()
	{
		return curl_close($this->resource);
	}

	private function copy_handle()
	{
		return curl_copy_handle($this->resource);
	}

	private function error()
	{
		return curl_error($this->resource);
	}

	private function errorno()
	{
		return curl_errno($this->resource);
	}

	private function exec()
	{
		return curl_exec($this->resource);
	}

	private function getinfo($option = 0)
	{
		return curl_getinfo($this->resource, $option);
	}

	private function init($url = NULL)
	{
		return curl_init($url);
	}

	private function setopt($option, $value)
	{
		return curl_setopt($this->resource, $option, $value);
	}

	private function setopt_array($options)
	{
		return curl_setopt_array($this->resource, $options);
	}

	private function version($age = CURLVERSION_NOW)
	{
		return curl_version($age);
	}

} // End of fURI cURL Library