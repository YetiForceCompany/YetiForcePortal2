<?php

/**
 * <b>AppException</b> is the base class for
 * all Exceptions.
 * @package YetiForce.API
 * @link http://php.net/manual/en/class.exception.php
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class AppException extends \Exception
{

	public function __construct($message, $code = 200, Exception $previous = null)
	{
		if(\Config::getBoolean('debugApi')){
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
 * @throws \AppException
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	throw new \AppException($errstr, $errno);
}
set_error_handler('exceptionErrorHandler');
