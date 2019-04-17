<?php
/**
 * WebUI class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

use YF\Modules\Base\Model;

class WebUI
{
	/**
	 * Process.
	 *
	 * @param Request $request
	 *
	 * @throws AppException
	 */
	public function process(Request $request)
	{
		try {
			$module = $request->getModule();
			$view = $request->getByType('view', Purifier::ALNUM);
			$action = $request->getByType('action', Purifier::ALNUM);
			if (false === $this->isInstalled() && 'Install' != $module) {
				header('Location:index.php?module=Install&view=Install');
				return;
			}
			$userInstance = User::getUser();
			if (empty($module)) {
				if ($userInstance && $userInstance->hasLogin()) {
					$module = Config::$defaultModule;
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
				$handler = new $handlerClass($request);
				$handler->validateRequest();
				if ($handler->loginRequired() && !$userInstance->hasLogin()) {
					throw new AppException('Login is required');
				}
				$handler->checkPermission($request);
				$this->triggerPreProcess($handler, $request);
				$handler->process($request);
				$this->triggerPostProcess($handler, $request);
			} else {
				throw new AppException("HANDLER_NOT_FOUND: $handlerClass");
			}
		} catch (\Throwable $e) {
			if ($request->isAjax() && $request->isEmpty('view')) {
				$response = new \App\Response();
				$response->setResult([
					'message' => $e->getMessage(),
					'trace' => $e->getTraceAsString()
				]);
				$response->emit();
			} else {
				\App\AppException::view($e);
			}
		}
	}

	public function isInstalled()
	{
		return '__CRM_PATH__' != Config::$crmUrl;
	}

	protected function triggerPreProcess($handler, $request)
	{
		if ($request->isAjax()) {
			$handler->preProcessAjax($request);
			return;
		}
		$handler->preProcess($request);
	}

	protected function triggerPostProcess($handler, $request)
	{
		if ($request->isAjax()) {
			$handler->postProcessAjax($request);
			return;
		}
		$handler->postProcess($request);
	}

	protected function triggerCheckPermission($handler, $request)
	{
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		if (empty($moduleModel)) {
			throw new AppException(Language::translate('LBL_HANDLER_NOT_FOUND'));
		}

		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

		if ($permission) {
			$handler->checkPermission($request);
			return;
		}
		throw new AppException(Language::translate($moduleName) . ' ' . Language::translate('LBL_NOT_ACCESSIBLE'));
	}
}
