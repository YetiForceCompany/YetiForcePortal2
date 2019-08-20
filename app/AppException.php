<?php
/**
 * <b>AppException</b> is the base class for
 * all Exceptions.
 *
 * @see      http://php.net/manual/en/class.exception.php
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class AppException extends \Exception
{
	public $tplName = 'Exception.tpl';

	private $backtrace;

	public function __construct($message, $code = 200, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->backtrace = \App\Debug::getBacktrace();
	}

	public static function view(\Throwable $e)
	{
		if (Config::get('displayDetailsException')) {
			$tplName = 'Exception.tpl';
			if (!empty($e->tplName)) {
				$tplName = $e->tplName;
			}
		} else {
			$tplName = 'ShortException.tpl';
		}

		if (empty($e->backtrace)) {
			$backtrace = $e->getTraceAsString();
		} else {
			$backtrace = $e->backtrace;
		}
		$cssFileNames = [
			YF_ROOT_WWW . 'libraries/bootstrap/dist/css/bootstrap.css',
			YF_ROOT_WWW . 'libraries/bootstrap-material-design/dist/css/bootstrap-material-design.css',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
		];
		$viewer = new \App\Viewer();
		$viewer->assign('MESSAGE', $e->getMessage());
		$viewer->assign('CODE', $e->getCode());
		$viewer->assign('BACKTRACE', nl2br($backtrace));
		$viewer->assign('SESSION', $_SESSION);
		$viewer->assign('CSS_FILE', $cssFileNames);
		$viewer->view($tplName);
		if (\App\Config::$debugApi && \App\Session::has('debugApi') && \App\Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', \App\Session::get('debugApi'));
			$viewer->assign('COLLAPSE', true);
			$viewer->view('DebugApi.tpl');
			\App\Session::set('debugApi', false);
		}
	}
}
