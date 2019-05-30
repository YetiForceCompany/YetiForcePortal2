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
	protected $moduleName;
	protected $defaultView = 'ListView';

	public static function getInstance($module)
	{
		$handlerModule = App\Loader::getModuleClassName($module, 'Model', 'Module');
		return new $handlerModule($module);
	}

	public function __construct(string $moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Function to check permission for a Module/Action.
	 *
	 * @param string $module
	 * @param string $action
	 *
	 * @return bool
	 */
	public static function isPermitted(string $module, string $action)
	{
		if (!\App\Session::has('modulePermissions')) {
			\App\Session::set('modulePermissions', []);
		}
		$data = \App\Session::get('modulePermissions');
		if (!isset($data[$module])) {
			$data[$module] = \App\Api::getInstance()->call($module . '/Privileges');
			\App\Session::set('modulePermissions', $data);
		}
		if (isset($data[$module][$action]) && !empty($data[$module][$action])) {
			return true;
		}
		return false;
	}

	/**
	 * Returns default view for module.
	 *
	 * @return string
	 */
	public function getDefaultView(): string
	{
		return $this->defaultView;
	}

	/**
	 * Returns default address url.
	 *
	 * @return string
	 */
	public function getDefaultUrl(): string
	{
		return "index.php?module={$this->moduleName}&view={$this->defaultView}";
	}
}
