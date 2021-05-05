<?php
/**
 * Base controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

use App\Request;

abstract class Base
{
	/**
	 * Request object.
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * Construct.
	 *
	 * @param \App\Request $request
	 */
	public function __construct(Request $request)
	{
		if (\App\Config::get('csrfProtection')) {
			require_once ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'config/csrf_config.php';
			\CsrfMagic\Csrf::init();
		}
		$this->request = $request;
		self::setHeaders();
	}

	/**
	 * Set headers.
	 *
	 * @return void
	 */
	public function setHeaders(): void
	{
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		if ((!empty($_SERVER['HTTPS']) && 'off' != strtolower($_SERVER['HTTPS'])) || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' == strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']))) {
			header('Pragma: private');
			header('Cache-Control: private, must-revalidate');
		} else {
			header('Cache-Control: private, no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}
	}

	/**
	 * Login required.
	 *
	 * @return bool
	 */
	public function loginRequired(): bool
	{
		return true;
	}

	/**
	 * Main action.
	 *
	 * @return void
	 */
	abstract public function process();

	/**
	 * Validates request. Checks type of request.
	 *
	 * @return void
	 */
	abstract public function validateRequest();

	/**
	 * Action invoke before process.
	 *
	 * @return void
	 */
	abstract public function preProcess();

	/**
	 * Action invoke after process.
	 *
	 * @return void
	 */
	abstract public function postProcess();

	/**
	 * Action invoke before process for AJAX.
	 *
	 * @return void
	 */
	abstract public function preProcessAjax();

	/**
	 * Action invoke after process for AJAX.
	 *
	 * @return void
	 */
	abstract public function postProcessAjax();

	/**
	 * Error handler.
	 *
	 * @param string $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param string $errline
	 * @param string $errcontext
	 *
	 * @return void
	 */
	public static function exceptionErrorHandler(int $errno, string $errstr, $errfile, $errline, $errcontext)
	{
		throw new \App\Exceptions\AppException($errstr, $errno);
	}
}
