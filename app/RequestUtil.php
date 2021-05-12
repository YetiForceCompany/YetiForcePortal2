<?php
/**
 * Request Utils basic file.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Request Utils basic class.
 */
class RequestUtil
{
	/**
	 * Cache https check variable.
	 *
	 * @var bool
	 */
	protected static $httpsCache;

	/**
	 * Check that the connection is https.
	 *
	 * @return bool
	 */
	public static function isHttps(): bool
	{
		if (!isset(self::$httpsCache)) {
			self::$httpsCache = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']))
				|| (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']));
		}
		return self::$httpsCache;
	}
}
