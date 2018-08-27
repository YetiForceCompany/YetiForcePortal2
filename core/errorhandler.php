<?php
/**
 * @link      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

/**
 * Sets a AppException error handler function.
 *
 * @link http://php.net/manual/en/function.set-error-handler.php
 *
 * @param int    $errno
 * @param string $errstr
 * @param string $errfile
 * @param int    $errline
 * @param array  $errcontext
 *
 * @throws AppException
 */
function exceptionErrorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	throw new \YF\Core\AppException($errstr, $errno);
}
