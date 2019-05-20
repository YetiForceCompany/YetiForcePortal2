<?php
/**
 * Log class.
 *
 * @see      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Sławomir Kłos <s.klos@yetiforce.com>
 */

namespace App;

class Log extends \Exception
{
	protected static $Messages = [];

	public static function message($message, $type = 'NOTICE', $file = null, $line = null)
	{
		self::$Messages[] = ['message' => $message, 'type' => $type, 'file' => $file, 'line' => $line];
	}

	public static function isEmpty(): bool
	{
		return !count(self::$Messages);
	}

	public static function display()
	{
		if (!\App\Config::$debugConsole) {
			return [];
		}
		$log = self::$Messages;
		self::$Messages = [];
		return $log;
	}
}
