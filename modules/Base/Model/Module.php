<?php
/**
 * Basic module model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App;

class Module
{
	protected $defaultView = 'ListView';

	public static function getInstance($module)
	{
		$handlerModule = App\Loader::getModuleClassName($module, 'Model', 'Module');
		$instance = new $handlerModule();
		return $instance;
	}

	/**
	 * Function to check permission for a Module/Action.
	 *
	 * @param string $module
	 * @param string $action
	 *
	 * @return bool
	 */
	public static function isPermitted($module, $action)
	{
		if (!\App\Session::has('modulePermissions')) {
			\App\Session::set('modulePermissions', []);
		}
		$data = \App\Session::get('modulePermissions');
		if (!isset($data[$module])) {
			$permissions = \App\Api::getInstance()->call($module . '/Privileges');
			$data[$module] = $permissions['standardActions'];
			\App\Session::set('modulePermissions', $data);
		}
		if (isset($data[$module][$action]) && !empty($data[$module][$action])) {
			return true;
		}
		return false;
	}

	public function getDefaultView()
	{
		return $this->defaultView;
	}
}
