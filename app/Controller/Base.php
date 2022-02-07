<?php
/**
 * Base controller class.
 *
 * @package   Controller
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

abstract class Base
{
	/** @var \App\Headers Headers instance. */
	public $headers;

	/** @var \App\Request Request object. */
	protected $request;

	/** @var string Module name. */
	protected $moduleName;

	/**
	 * Construct.
	 *
	 * @param \App\Request $request
	 */
	public function __construct(\App\Request $request)
	{
		$this->headers = \App\Controller\Headers::getInstance();
		if (\App\Config::get('csrfProtection')) {
			require_once ROOT_DIRECTORY . '/config/csrf_config.php';
			\CsrfMagic\Csrf::init();
		}
		$this->request = $request;
		$this->moduleName = $request->getModule();
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
	 * Send headers.
	 */
	public function sendHeaders()
	{
		$this->headers->send();
	}

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
