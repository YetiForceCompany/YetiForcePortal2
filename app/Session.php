<?php
/**
 * Sesion class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App;

class Session
{
	/**
	 * Get value from session.
	 *
	 * @param string $key
	 * @param mixed  $defaultValue
	 *
	 * @return mixed for the key
	 */
	public static function get($key, $defaultValue = false)
	{
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		return $defaultValue;
	}

	/**
	 * @param string $key Key in table
	 *
	 * @return bool if key is definied - return true
	 */
	public static function has($key): bool
	{
		return isset($_SESSION[$key]);
	}

	/**
	 * @param $key   Key in table
	 * @param $value Value for the key
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}
