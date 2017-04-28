<?php
/**
 * Basic Module Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\Model;

use Core;

class Module
{

	protected $defaultView = 'ListView';

	public function getDefaultView()
	{
		return $this->defaultView;
	}

	public static function getInstance($module)
	{
		$handlerModule = Core\Loader::getModuleClassName($module, 'Model', 'Module');
		$instance = new $handlerModule();
		return $instance;
	}

	/**
	 * Function to check permission for a Module/Action
	 * @param string $module
	 * @param string $action
	 * @return boolean
	 */
	public static function isPermitted($module, $action)
	{
		if (!\Core\Session::has('modulePermissions')) {
			\Core\Session::set('modulePermissions', []);
		}
		$data = \Core\Session::get('modulePermissions');
		if (!isset($data[$module])) {
			$permissions = \Core\Api::getInstance()->call($module . '/Privileges');
			$data[$module] = $permissions['standardActions'];
			\Core\Session::set('modulePermissions', $data);
		}
		if (isset($data[$module][$action]) && !empty($data[$module][$action])) {
			return true;
		}
		return false;
	}
}
