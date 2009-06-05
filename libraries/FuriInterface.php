<?php defined('SYSPATH') OR die('No direct access allowed.');

interface FuriInterface {

	public function get($url);

	public function post($url);

	public function put($url);

	public function delete($url);

// ----------------------------------------------------------------------------

	/**
	 * Data
	 *
	 * Used to set the data that will be included as the URL query string,
	 * POST data, etc.
	 *
	 * Yeah, I called it data and it takes an argument named $data, you wanna
	 * fight about it?
	 *
	 * @param string|array $data
	 * @return object returns $this for method chaining
	 */
	public function data($data);

	public function method($method);

	public function request($url);

// ----------------------------------------------------------------------------

	public function copy_cookies();

	public function copy_headers();

	public function set_header($header);

	public function set_option($option, $value);

} // End FuriInterface