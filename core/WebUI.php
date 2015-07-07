<?php

/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

class Core_WebUI {

	public function process(Core_Request $request) {
		$module = $request->getModule();
		$view = $request->get('view');
		$action = $request->get('action');
		$response = false;

		try {
			if ($this->isInstalled() === false && $module != 'Install') {
				
			}

			if (empty($module)) {
				if (Core_User::hasLogin()) {
					$module = Config::get('defaultModule');
					$moduleInstance = Base_Model_Module::getInstance($module);
					$view = $moduleInstance->getDefaultView();
				} else {
					$module = 'Users';
					$view = 'Login';
				}
				$request->set('module', $module);
				$request->set('view', $view);
			}

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
			$handlerClass = Core_Loader::getModuleClassName($module, $componentType, $componentName);
			$handler = new $handlerClass();

			if ($handler) {
				// $user = Core_User::getUser();

				if ($handler->loginRequired()) {
					$this->checkLogin($request);
				}

				//$this->triggerCheckPermission($handler, $request);

				// Every settings page handler should implement this method
				if (stripos($qualifiedModuleName, 'Settings') === 0 || ($module == 'Users')) {
					$handler->checkPermission($request);
				}

				$notPermittedModules = array('ModComments', 'Integration', 'DashBoard');

				if (in_array($module, $notPermittedModules) && $view == 'List') {
					header('Location:index.php?module=Home&view=DashBoard');
				}

				$this->triggerPreProcess($handler, $request);
				$response = $handler->process($request);
				$this->triggerPostProcess($handler, $request);
			} else {
				throw new PortalException(vtranslate('LBL_HANDLER_NOT_FOUND'));
			}
		} catch (PortalException $e) {
			if (false) {
				// Log for developement.
				//error_log($e->getTraceAsString(), E_ERROR);
				die($e->getMessage());
			} else {
				die(Core_Json::encode($e->getMessage()));
			}
		}

		if ($response) {
			$response->emit();
		}
	}
	
	protected function triggerCheckPermission($handler, $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		if (empty($moduleModel)) {
			throw new AppException(vtranslate('LBL_HANDLER_NOT_FOUND'));
		}

		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

		if ($permission) {
			$handler->checkPermission($request);
			return;
		}
		throw new AppException(vtranslate($moduleName) . ' ' . vtranslate('LBL_NOT_ACCESSIBLE'));
	}

	protected function triggerPreProcess($handler, $request) {
		if ($request->isAjax()) {
			return true;
		}
		$handler->preProcess($request);
	}

	protected function triggerPostProcess($handler, $request) {
		if ($request->isAjax()) {
			return true;
		}
		$handler->postProcess($request);
	}

	function isInstalled() {
		return !file_exists('modules/Install');
	}

}
