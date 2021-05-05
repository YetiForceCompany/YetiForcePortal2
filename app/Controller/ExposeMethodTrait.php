<?php

namespace App\Controller;

/**
 * Trait expose method controller class.
 *
 * @package   Controller
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */
trait ExposeMethodTrait
{
	/**
	 * Control the exposure of methods to be invoked from client (kind-of RPC).
	 *
	 * @var string[]
	 */
	protected $exposedMethods = [];

	/**
	 * Function that will expose methods for external access.
	 *
	 * @param string $name - method name
	 */
	protected function exposeMethod(string $name)
	{
		if (!\in_array($name, $this->exposedMethods)) {
			$this->exposedMethods[] = $name;
		}
	}

	/**
	 * Function checks if the method is exposed for client usage.
	 *
	 * @param string $name - method name
	 *
	 * @return bool
	 */
	public function isMethodExposed(string $name): bool
	{
		return \in_array($name, $this->exposedMethods);
	}

	/**
	 * Function invokes exposed methods for this class.
	 *
	 * @param string $methodName - method name
	 *
	 * @throws \App\Exceptions\BadRequest
	 *
	 * @return mixed
	 */
	public function invokeExposedMethod(string $methodName)
	{
		if (!empty($methodName) && $this->isMethodExposed($methodName)) {
			return $this->{$methodName}();
		}
		throw new \App\Exceptions\BadRequest('ERR_NOT_ACCESSIBLE', 406);
	}

	/**
	 * Process action.
	 */
	public function process()
	{
		if ($mode = $this->request->getMode()) {
			$this->invokeExposedMethod($mode);
		}
	}
}
