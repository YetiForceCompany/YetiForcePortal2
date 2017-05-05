<?php
/**
 * @package YetiForce.API
 * @link http://php.net/manual/en/class.exception.php
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

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
