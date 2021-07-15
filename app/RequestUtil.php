<?php
/**
 * Request Utils basic file.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
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
	 * Browser cache variable.
	 *
	 * @var stdClass
	 */
	protected static $browserCache;

	/**
	 * Get browser details.
	 *
	 * @return object
	 */
	public static function getBrowserInfo(): object
	{
		if (empty(self::$browserCache)) {
			$browserAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$browser = new \stdClass();
			$browser->win = false !== strpos($browserAgent, 'win');
			$browser->mac = false !== strpos($browserAgent, 'mac');
			$browser->linux = false !== strpos($browserAgent, 'linux');
			$browser->unix = false !== strpos($browserAgent, 'unix');
			$browser->webkit = false !== strpos($browserAgent, 'applewebkit');
			$browser->opera = false !== strpos($browserAgent, 'opera') || ($browser->webkit && false !== strpos($browserAgent, 'opr/'));
			$browser->ns = false !== strpos($browserAgent, 'netscape');
			$browser->chrome = !$browser->opera && false !== strpos($browserAgent, 'chrome');
			$browser->ie = !$browser->opera && (false !== strpos($browserAgent, 'compatible; msie') || false !== strpos($browserAgent, 'trident/'));
			$browser->safari = !$browser->opera && !$browser->chrome && ($browser->webkit || false !== strpos($browserAgent, 'safari'));
			$browser->mz = !$browser->ie && !$browser->safari && !$browser->chrome && !$browser->ns && !$browser->opera && false !== strpos($browserAgent, 'mozilla');

			if (preg_match('/ ([a-z]{2})-([a-z]{2})/', $browserAgent, $regs)) {
				$browser->lang = $regs[1];
			} else {
				$browser->lang = 'en';
			}
			$browser->https = self::isHttps();
			self::$browserCache = $browser;
		}
		return self::$browserCache;
	}

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
			self::$requestId = sprintf('%08x', abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME_FLOAT'] . $_SERVER['REMOTE_PORT'])));
		}
		return self::$requestId;
	}
}
