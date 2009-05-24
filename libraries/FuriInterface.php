<?php defined('SYSPATH') OR die('No direct access allowed.');

interface FuriInterface {

	public function get($url);

	public function post($url);

	public function put($url);

	public function delete($url);

	public function method($method);

	public function request($url);

	public function copy_cookies();

	public function copy_headers();

	public function get_headers();

	public function get_info();

	public function get_options();

	public function set_header($header);

	public function set_option($option, $value);

	public function set_options($options);

} // End of FuriInterface Interface