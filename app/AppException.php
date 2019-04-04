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

	public function __construct($message, $code = 200, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->backtrace = \App\Debug::getBacktrace(3);
	}

	public static function view(\Throwable $e)
	{
		$tplName = 'Exception.tpl';
		if (!empty($e->tplName)) {
			$tplName = $e->tplName;
		}
		if (empty($e->backtrace)) {
			$backtrace = $e->getTraceAsString();
		} else {
			$backtrace = $e->backtrace;
		}
		$viewer = new \App\Viewer();
		$viewer->assign('MESSAGE', $e->getMessage());
		$viewer->assign('CODE', $e->getCode());
		$viewer->assign('BACKTRACE', nl2br($backtrace));
		$viewer->view($tplName);
	}
}
