<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

class Core_WebUI {
	
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
		throw new AppException(vtranslate($moduleName).' '.vtranslate('LBL_NOT_ACCESSIBLE'));
	}

	protected function triggerPreProcess($handler, $request) {
		if($request->isAjax()){
			return true;
		}
		$handler->preProcess($request);
	}

	protected function triggerPostProcess($handler, $request) {
		if($request->isAjax()){
			return true;
		}
		$handler->postProcess($request);
	}

	function isInstalled() {
		return !file_exists('modules/Install');
	}

	function process (Core_Request $request) {
		$user = Core_User::getUser();

		$currentLanguage = Core_Language::getLanguage();
		$module = $request->getModule();
/*
		if ($currentUser && $qualifiedModuleName) {
			$moduleLanguageStrings = Core_Language::getModuleStringsFromFile($currentLanguage,$qualifiedModuleName);
			vglobal('mod_strings', $moduleLanguageStrings['languageStrings']);
		}
*/
		$view = $request->get('view');
		$action = $request->get('action');
		$response = false;

		try {
			if($this->isInstalled() === false && $module != 'Install') {
				
			}

			if(empty($module)) {
				if (Core_User::hasLogin()) {
					$defaultModule = Config::get('defaultModule');
					if(!empty($defaultModule) && $defaultModule != 'Home') {
						$module = $defaultModule; 
						$view = 'List';
					} else {
						$module = 'Home'; 
						$view = 'DashBoard';
					}
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
				if(empty($view)) {
					$view = 'Index';
				}
				$componentName = $view;
			}
			$handlerClass = Core_Loader::getModuleClassName($module, $componentType, $componentName);
			$handler = new $handlerClass();
			
            if ($handler) {
                vglobal('currentModule', $module);
				$csrfProtection = vglobal('csrfProtection');
                if ($csrfProtection) {
					// Ensure handler validates the request
					$handler->validateRequest($request);
				}

				if ($handler->loginRequired()) {
					$this->checkLogin ($request);
				}

				//TODO : Need to review the design as there can potential security threat
				$skipList = array('Users', 'Home', 'CustomView', 'Import', 'Export', 'Inventory', 'Vtiger','PriceBooks','Migration','Install');

				if(!in_array($module, $skipList) && stripos($qualifiedModuleName, 'Settings') === false) {
					$this->triggerCheckPermission($handler, $request);
				}

				// Every settings page handler should implement this method
				if(stripos($qualifiedModuleName, 'Settings') === 0 || ($module=='Users')) {
					$handler->checkPermission($request);
				}

				$notPermittedModules = array('ModComments','Integration' ,'DashBoard');

				if(in_array($module, $notPermittedModules) && $view == 'List'){
					header('Location:index.php?module=Home&view=DashBoard');
				}

				$this->triggerPreProcess($handler, $request);
				$response = $handler->process($request);
				$this->triggerPostProcess($handler, $request);
			} else {
				throw new PortalException(vtranslate('LBL_HANDLER_NOT_FOUND'));
			}
		} catch(Exception $e) {
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
}
