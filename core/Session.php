<?php
/**
 * Sesion class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
namespace YF\Core;

class Session
{

	/**
	 *
	 * @param string $key Key in table
	 * @return Value for the key
	 */
	public static function get($key)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return false;
	}

	/**
	 *
	 * @param string $key Key in table
	 * @return boolean if key is definied - return true
	 */
	public static function has($key)
	{
		return isset($_SESSION[$key]);
	}

	/**
	 *
	 * @param $key Key in table
	 * @param $value Value for the key
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}
