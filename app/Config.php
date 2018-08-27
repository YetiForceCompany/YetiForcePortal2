<?php
/**
 * Config class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class Config
{
	protected static $config;

	/** Get boolean value */
	public static function getBoolean($key, $defvalue = false)
	{
		return self::get($key, $defvalue);
	}

	public static function get($key, $defvalue = '')
	{
		if (empty(self::$config)) {
			require YF_ROOT . DIRECTORY_SEPARATOR . 'config/config.php';
			self::$config = $config;
		}
		if (isset(self::$config)) {
			if (isset(self::$config[$key])) {
				return self::$config[$key];
			}
		}
		return $defvalue;
	}
}
