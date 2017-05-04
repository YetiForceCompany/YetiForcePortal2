<?php
/**
 * <b>AppException</b> is the base class for
 * all Exceptions.
 * @package YetiForce.API
 * @link http://php.net/manual/en/class.exception.php
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Core;

class AppException extends \Exception
{

	public function __construct($message, $code = 200, Exception $previous = null)
	{
		if (\YF\Core\Config::getBoolean('debugApi')) {
			echo '<pre>';
			debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			echo '</pre>';
		}
		die($message);
	}
}

/**
 * Sets a AppException error handler function
 * @link http://php.net/manual/en/function.set-error-handler.php
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 * @param array $errcontext
 * @throws \YF\Core\AppException
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	throw new \YF\Core\AppException($errstr, $errno);
}
set_error_handler('exceptionErrorHandler');
