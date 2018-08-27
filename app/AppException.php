<?php
/**
 * <b>AppException</b> is the base class for
 * all Exceptions.
 *
 * @link      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class AppException extends \Exception
{
	public function __construct($message, $code = 200, Exception $previous = null)
	{
		if (Config::getBoolean('debugApi')) {
			echo '<pre>';
			debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			echo '</pre>';
		}
		die($message);
	}
}
