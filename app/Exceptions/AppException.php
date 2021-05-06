<?php
/**
 * Main exceptions file.
 *
 * @package App
 *
 * @see      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Exceptions;

/**
 * Main exceptions class.
 */
class AppException extends \Exception
{
	/** @var string Default error exception template. */
	public static $tplName = 'Exception.tpl';

	/**
	 * Construct the exception.
	 *
	 * @param string     $message
	 * @param int        $code
	 * @param \Throwable $previous
	 */
	public function __construct($message, $code = 200, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->backtrace = \App\Debug::getBacktrace();
	}

	/**
	 * Show view.
	 *
	 * @param \Throwable $e
	 *
	 * @return void
	 */
	public static function view(\Throwable $e): void
	{
		$viewer = new \App\Viewer();
		if (\App\Config::get('displayDetailsException')) {
			$viewer->assign('MESSAGE', $e->getMessage());
			$viewer->assign('BACKTRACE', empty($e->backtrace) ? $e->getTraceAsString() : $e->backtrace);
			$viewer->assign('SESSION', $_SESSION);
		}
		$viewer->assign('CODE', $e->getCode());
		$viewer->assign('CSS_FILE', [
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free/css/all.css',
			PUBLIC_DIRECTORY . 'libraries/@mdi/font/css/materialdesignicons.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap/dist/css/bootstrap.css',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
		]);
		$viewer->assign('JS_FILE', [
			PUBLIC_DIRECTORY . 'libraries/jquery/dist/jquery.js',
			PUBLIC_DIRECTORY . 'libraries/bootstrap/dist/js/bootstrap.js',
		]);
		$viewer->view($e->tplName ?? self::$tplName);
		if (\App\Config::$debugApi && \App\Session::has('debugApi') && \App\Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', \App\Session::get('debugApi'));
			$viewer->assign('COLLAPSE', true);
			$viewer->view('DebugApi.tpl');
			\App\Session::set('debugApi', false);
		}
	}
}
