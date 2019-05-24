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
	public static function get(string $key, $defaultValue = false)
	{
		return \array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $defaultValue;
	}

	/**
	 * @param string $key Key in table
	 *
	 * @return bool if key is definied - return true
	 */
	public static function has(string $key): bool
	{
		return \array_key_exists($key, $_SESSION);
	}

	/**
	 * @param $key   Key in table
	 * @param $value Value for the key
	 */
	public static function set(string $key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * Unset value.
	 *
	 * @param string $key
	 *
	 * @return void
	 */
	public static function unset(string $key)
	{
		if (\array_key_exists($key, $_SESSION)) {
			unset($_SESSION[$key]);
		}
	}
}
