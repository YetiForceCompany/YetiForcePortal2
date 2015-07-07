<?php

abstract class Core_Controller {

	public function __construct() {
		self::setHeaders();
	}

	public function loginRequired() {
		return true;
	}

	abstract function getViewer(Core_Request $request);

	abstract function process(Core_Request $request);

	public function validateRequest(Core_Request $request) {
		
	}

	public function preProcess(Core_Request $request) {
		
	}

	public function postProcess(Core_Request $request) {
		
	}

	// Control the exposure of methods to be invoked from client (kind-of RPC)
	protected $exposedMethods = array();

	/**
	 * Function that will expose methods for external access
	 * @param <String> $name - method name
	 */
	protected function exposeMethod($name) {
		if (!in_array($name, $this->exposedMethods)) {
			$this->exposedMethods[] = $name;
		}
	}

	/**
	 * Function checks if the method is exposed for client usage
	 * @param string $name - method name
	 * @return boolean
	 */
	public function isMethodExposed($name) {
		if (in_array($name, $this->exposedMethods)) {
			return true;
		}
		return false;
	}

	public function invokeExposedMethod() {
		$parameters = func_get_args();
		$name = array_shift($parameters);
		if (!empty($name) && $this->isMethodExposed($name)) {
			return call_user_func_array(array($this, $name), $parameters);
		}
		throw new PortalException(vtranslate('LBL_NOT_ACCESSIBLE'));
	}

	public function setHeaders() {
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
