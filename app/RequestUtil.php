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
	/** @var bool Cache https check variable. */
	protected static $httpsCache;

	/** @var string Cache request id variable. */
	protected static $requestId;

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

	/**
	 * Get request id.
	 *
	 * @return string
	 */
	public static function requestId(): string
	{
		if (empty(self::$requestId)) {
			self::$requestId = sprintf('%08x', abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME'] . $_SERVER['REMOTE_PORT'])));
		}
		return self::$requestId;
	}
}
