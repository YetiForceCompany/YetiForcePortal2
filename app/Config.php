<?php
/**
 * The file contains: Config class.
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Config class.
 */
class Config extends \Conf\Config
{
	/**
	 * Js environment variables.
	 *
	 * @var array
	 */
	private static $jsEnv = [];

	/**
	 * Get all js configuratin in json.
	 *
	 * @return type
	 */
	public static function getJsEnv()
	{
		return Json::encode(self::$jsEnv);
	}

	/**
	 * Set js environment variables.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	public static function setJsEnv($key, $value)
	{
		self::$jsEnv[$key] = $value;
	}

	/**
	 * Get bool config value.
	 *
	 * @param string $key
	 * @param bool   $default
	 *
	 * @return bool
	 */
	public static function getBool(string $key, bool $default = false): bool
	{
		return self::get($key, $default);
	}

	/**
	 * Get integer config value.
	 *
	 * @param string $key
	 * @param bool   $default
	 *
	 * @return int
	 */
	public static function getInt(string $key, int $default = 0): int
	{
		return self::get($key, $default);
	}

	/**
	 * Get config value.
	 *
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function get(string $key, $default = null)
	{
		return property_exists(self::class, $key) ? self::${$key} : $default;
	}
}
