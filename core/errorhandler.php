<?php
/**
 * @package YetiForce.API
 * @link http://php.net/manual/en/class.exception.php
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
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
 * @throws AppException
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	throw new AppException($errstr, $errno);
}
