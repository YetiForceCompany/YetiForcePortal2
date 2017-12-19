<?php
/**
 * Log class
 * @package YetiForce.Core
 * @link http://php.net/manual/en/class.exception.php
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Sławomir Kłos <s.klos@yetiforce.com>
 */
namespace YF\Core;

class Log extends \Exception
{

	protected static $Messages = array();

	public static function message($message, $type = 'NOTICE', $file = null, $line = null)
	{
		self::$Messages[] = array('message' => $message, 'type' => $type, 'file' => $file, 'line' => $line);
	}

	public static function isEmpty()
	{
		if (count(self::$Messages)) {
			return false;
		} else {
			return true;
		}
	}

	public static function display()
	{
		if (!\YF\Core\Config::getBoolean('debugConsole')) {
			return array();
		}
		$log = self::$Messages;
		self::$Messages = array();
		return $log;
	}
}
