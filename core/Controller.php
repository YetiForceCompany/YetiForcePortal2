<?php
/**
 * Base controller class
 * @package YetiForce.Core
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Core;

abstract class Controller
{

	public function __construct()
	{
		self::setHeaders();
	}

	public function loginRequired()
	{
		return true;
	}

	abstract function getViewer(Request $request);

	abstract function process(Request $request);

	public function validateRequest(Request $request)
	{
		
	}

	public function preProcess(Request $request)
	{
		
	}

	public function postProcess(Request $request)
	{
		
	}

	// Control the exposure of methods to be invoked from client (kind-of RPC)
	protected $exposedMethods = array();

	/**
	 * Function that will expose methods for external access
	 * @param <String> $name - method name
	 */
	protected function exposeMethod($name)
	{
		if (!in_array($name, $this->exposedMethods)) {
			$this->exposedMethods[] = $name;
		}
	}

	/**
	 * Function checks if the method is exposed for client usage
	 * @param string $name - method name
	 * @return boolean
	 */
	public function isMethodExposed($name)
	{
		if (in_array($name, $this->exposedMethods)) {
			return true;
		}
		return false;
	}

	public function invokeExposedMethod()
	{
		$parameters = func_get_args();
		$name = array_shift($parameters);
		if (!empty($name) && $this->isMethodExposed($name)) {
			return call_user_func_array(array($this, $name), $parameters);
		}
		throw new AppException(Functions::translate('LBL_NOT_ACCESSIBLE'));
	}

	public function setHeaders()
	{
		header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

		if ((!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https')) {
			header('Pragma: private');
			header('Cache-Control: private, must-revalidate');
		} else {
			header('Cache-Control: private, no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}
	}
}
