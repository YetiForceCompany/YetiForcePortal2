<?php
/**
 * Base controller file.
 *
 * @package   Controller
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

/**
 * Base controller class.
 */
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
	 * @param int    $no
	 * @param string $str
	 * @param string $file
	 * @param int    $line
	 *
	 * @throws \App\Exceptions\AppException
	 *
	 * @return void
	 */
	public static function exceptionErrorHandler(int $no, string $str, string $file, int $line): void
	{
		if (\in_array($no, [E_ERROR, E_WARNING, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
			$file = rtrim(str_replace(ROOT_DIRECTORY . \DIRECTORY_SEPARATOR, '', $file));
			throw new \App\Exceptions\AppException("{$str} in {$file}:{$line}", $no);
		}
	}
}
