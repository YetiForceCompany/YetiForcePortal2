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
	 * Session and cookie init.
	 *
	 * @return void
	 */
	public static function init(): void
	{
		if (PHP_SESSION_ACTIVE === session_status()) {
			return;
		}
		$cookie = session_get_cookie_params();
		$cookie['secure'] = \App\RequestUtil::isHttps();
		if (isset($_SERVER['HTTP_HOST'])) {
			$cookie['domain'] = strtok($_SERVER['HTTP_HOST'], ':');
		}
		if (isset(\App\Config::$cookieForceHttpOnly)) {
			$cookie['httponly'] = \App\Config::$cookieForceHttpOnly;
		}
		if ($cookie['secure']) {
			$cookie['samesite'] = \App\Config::$cookieSameSite;
		}
		session_name(\App\Config::$sessionName ?: 'YFPSID');
		session_set_cookie_params($cookie);
		session_save_path(ROOT_DIRECTORY . '/cache/session');
		session_start();
	}

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
