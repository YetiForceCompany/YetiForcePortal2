<?php
/**
 * WebUI class
 * @package YetiForce.Core
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Core;

use YF\Modules\Base\Model;

class WebUI
{

	/**
	 * Process
	 * @param Request $request
	 * @throws AppException
	 */
	public function process(Request $request)
	{
		$request = Request::setInstance($request);
		$module = $request->getModule();
		$view = $request->get('view');
		$action = $request->get('action');
		$response = false;

		try {
			if ($this->isInstalled() === false && $module != 'Install') {
				header('Location:index.php?module=Install&view=Install');
				exit;
			}
			$userInstance = User::getUser();
			if (empty($module)) {
				if ($userInstance && $userInstance->hasLogin()) {
					$module = Config::get('defaultModule');
					$moduleInstance = Model\Module::getInstance($module);
					$view = $moduleInstance->getDefaultView();
				} else {
					$module = 'Users';
					$view = 'Login';
				}
			}
			$request->set('module', $module);
			$request->set('view', $view);

			if (!empty($action)) {
				$componentType = 'Action';
				$componentName = $action;
			} else {
				$componentType = 'View';
				if (empty($view)) {
					$view = 'Index';
				}
				$componentName = $view;
			}
			$handlerClass = Loader::getModuleClassName($module, $componentType, $componentName);

			if (class_exists($handlerClass)) {
				$handler = new $handlerClass();

				if ($handler->loginRequired() && !$userInstance->hasLogin()) {
					throw new AppException('Login is required');
				}
				$handler->checkPermission($request);
				$this->triggerPreProcess($handler, $request);
				$response = $handler->process($request);
				$this->triggerPostProcess($handler, $request);
			} else {
				echo ($module . $componentType . $componentName);
				throw new AppException("HANDLER_NOT_FOUND: $handlerClass");
			}
		} catch (AppException $e) {
			if (false) {
				// Log for developement.
				//error_log($e->getTraceAsString(), E_ERROR);
				die($e->getMessage());
			} else {
				die(Json::encode($e->getMessage()));
			}
		}

		if ($response) {
			$response->emit();
		}
	}

	protected function triggerCheckPermission($handler, $request)
	{
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		if (empty($moduleModel)) {
			throw new AppException(Functions::translate('LBL_HANDLER_NOT_FOUND'));
		}

		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

		if ($permission) {
			$handler->checkPermission($request);
			return;
		}
		throw new AppException(Functions::translate($moduleName) . ' ' . Functions::translate('LBL_NOT_ACCESSIBLE'));
	}

	protected function triggerPreProcess($handler, $request)
	{
		if ($request->isAjax()) {
			return true;
		}
		$handler->preProcess($request);
	}

	protected function triggerPostProcess($handler, $request)
	{
		if ($request->isAjax()) {
			return true;
		}
		$handler->postProcess($request);
	}

	function isInstalled()
	{
		return Config::get('crmPath') != '__CRM_PATH__';
	}
}
