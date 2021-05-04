<?php
/**
 * Exceptions file.
 *
 * @see      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Exceptions class.
 */
class AppException extends \Exception
{
	/**
	 * Default error exception template.
	 *
	 * @var string
	 */
	public $tplName = 'Exception.tpl';

	/**
	 *Construct the exception.
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

	public static function view(\Throwable $e)
	{
		if (empty($e->backtrace)) {
			$backtrace = $e->getTraceAsString();
		} else {
			$backtrace = $e->backtrace;
		}
		$cssFileNames = [
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free/css/all.css',
			PUBLIC_DIRECTORY . 'libraries/@mdi/font/css/materialdesignicons.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap/dist/css/bootstrap.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-material-design/dist/css/bootstrap-material-design.css',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
		];
		$viewer = new \App\Viewer();
		if (Config::get('displayDetailsException')) {
			$viewer->assign('MESSAGE', $e->getMessage());
			$viewer->assign('BACKTRACE', $backtrace);
			$viewer->assign('SESSION', $_SESSION);
		}
		$viewer->assign('CODE', $e->getCode());
		$viewer->assign('CSS_FILE', $cssFileNames);
		$viewer->view($e->tplName);
		if (\App\Config::$debugApi && \App\Session::has('debugApi') && \App\Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', \App\Session::get('debugApi'));
			$viewer->assign('COLLAPSE', true);
			$viewer->view('DebugApi.tpl');
			\App\Session::set('debugApi', false);
		}
	}
}
