<?php
/**
 * Config class
 * @package YetiForce.Config
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Core;

class Config
{

	protected static $config;

	public static function get($key, $defvalue = '')
	{
		if (empty(self::$config)) {
			require(YF_ROOT . DIRECTORY_SEPARATOR . 'config/config.php');
			self::$config = $config;
		}
		if (isset(self::$config)) {
			if (isset(self::$config[$key])) {
				return self::$config[$key];
			}
		}
		return $defvalue;
	}

	/** Get boolean value */
	public static function getBoolean($key, $defvalue = false)
	{
		return self::get($key, $defvalue);
	}
}
