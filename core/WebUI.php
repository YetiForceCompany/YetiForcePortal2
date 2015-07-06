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
		global $dbconfig;
		if (empty($dbconfig) || empty($dbconfig['db_name']) || $dbconfig['db_name'] == '_DBC_TYPE_') {
			//return false;
		}
		return true;
	}

	function process (Core_Request $request) {
		$user = Core_User::getUser();

		$currentLanguage = Core_Language::getLanguage();
		$module = $request->getModule();

		if ($currentUser && $qualifiedModuleName) {
			$moduleLanguageStrings = Vtiger_Language_Handler::getModuleStringsFromFile($currentLanguage,$qualifiedModuleName);
			vglobal('mod_strings', $moduleLanguageStrings['languageStrings']);
		}

		$view = $request->get('view');
		$action = $request->get('action');
		$response = false;

		try {
			if($this->isInstalled() === false && $module != 'Install') {
				header('Location:install/Install.php');
				exit;
			}

			if(empty($module)) {
				if ($this->hasLogin()) {
					$defaultModule = vglobal('default_module');
					if(!empty($defaultModule) && $defaultModule != 'Home') {
						$module = $defaultModule; $qualifiedModuleName = $defaultModule; $view = 'List';
                        if($module == 'Calendar') { 
                            // To load MyCalendar instead of list view for calendar
                            //TODO: see if it has to enhanced and get the default view from module model
                            $view = 'Calendar';
                        }
					} else {
						$module = 'Home'; $qualifiedModuleName = 'Home'; $view = 'DashBoard';
					}
				} else {
					$module = 'Users'; $qualifiedModuleName = 'Settings:Users'; $view = 'Login';
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
			$handlerClass = Vtiger_Loader::getComponentClassName($componentType, $componentName, $qualifiedModuleName);
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
				throw new AppException(vtranslate('LBL_HANDLER_NOT_FOUND'));
			}
		} catch(Exception $e) {
			if ($view) {
				// Log for developement.
				error_log($e->getTraceAsString(), E_NOTICE);
				Vtiger_Functions::throwNewException($e->getMessage());
			} else {
				$response = new Vtiger_Response();
				$response->setEmitType(Vtiger_Response::$EMIT_JSON);
				$response->setError($e->getMessage());
				//Vtiger_Functions::throwNewException($e->getMessage());
			}
		}

		if ($response) {
			$response->emit();
		}
	}
}
