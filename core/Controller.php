<?php
/**
 * Base controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Core;

abstract class Controller
{
	protected $exposedMethods = [];

	public function __construct()
	{
		self::setHeaders();
	}

	public function setHeaders()
	{
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		if ((!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) {
			header('Pragma: private');
			header('Cache-Control: private, must-revalidate');
		} else {
			header('Cache-Control: private, no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}
	}

	public function loginRequired()
	{
		return true;
	}

	abstract public function getViewer(Request $request);

	abstract public function process(Request $request);

	public function validateRequest(Request $request)
	{
	}

	// Control the exposure of methods to be invoked from client (kind-of RPC)

	public function preProcess(Request $request)
	{
	}

	public function postProcess(Request $request)
	{
	}

	public function invokeExposedMethod()
	{
		$parameters = func_get_args();
		$name = array_shift($parameters);
		if (!empty($name) && $this->isMethodExposed($name)) {
			return call_user_func_array([$this, $name], $parameters);
		}
		throw new AppException(Functions::translate('LBL_NOT_ACCESSIBLE'));
	}

	/**
	 * Function checks if the method is exposed for client usage.
	 *
	 * @param string $name - method name
	 *
	 * @return bool
	 */
	public function isMethodExposed($name)
	{
		if (in_array($name, $this->exposedMethods)) {
			return true;
		}
		return false;
	}

	/**
	 * Function that will expose methods for external access.
	 *
	 * @param <String> $name - method name
	 */
	protected function exposeMethod($name)
	{
		if (!in_array($name, $this->exposedMethods)) {
			$this->exposedMethods[] = $name;
		}
	}
}
