<?php
/**
 * <b>AppException</b> is the base class for
 * all Exceptions.
 * @package YetiForce.API
 * @link http://php.net/manual/en/class.exception.php
 * @license licenses/License.html
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
