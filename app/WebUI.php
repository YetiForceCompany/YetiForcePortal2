<?php
/**
 * WebUI class.
 *
 * @package App
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
	 * @throws \App\Exceptions\AppException
	 */
	public function process(Request $request)
	{
		\App\Log::init();
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
			if ('Logout' === $action && 'Users' === $module && !$userInstance->hasLogin() && !$request->isAjax()) {
				header('Location:index.php');
				return false;
			}
			$handlerClass = Loader::getModuleClassName($module, $componentType, $componentName);
			if (class_exists($handlerClass)) {
				$handler = new $handlerClass($request);
				$handler->validateRequest();
				if ($handler->loginRequired() && !$userInstance->hasLogin()) {
					header('Location:index.php');
				}
				$handler->checkPermission();
				$this->triggerPreProcess($handler, $request);
				$handler->process();
				$this->triggerPostProcess($handler, $request);
			} else {
				throw new Exceptions\AppException("HANDLER_NOT_FOUND: $handlerClass");
			}
		} catch (\Throwable $e) {
			if (401 === $e->getCode()) {
				unset($_SESSION);
				session_destroy();
				header('Location: ' . \App\Config::$portalUrl);
				return;
			}
			Log::error($e->__toString());
			if ($request->isAjax() && $request->isEmpty('view')) {
				$response = new \App\Response();
				$response->setException($e);
				$response->emit();
			} else {
				Exceptions\AppException::view($e);
			}
		}
	}

	public function isInstalled(): bool
	{
		return '__API_PATH__' != Config::$apiUrl;
	}

	/**
	 * Trigger pre process function.
	 *
	 * @param Controller\Base $handler
	 * @param Request         $request
	 *
	 * @return void
	 */
	protected function triggerPreProcess(Controller\Base $handler, Request $request): void
	{
		if ($request->isAjax()) {
			$handler->preProcessAjax();
			return;
		}
		$handler->preProcess();
	}

	/**
	 * Trigger post process function.
	 *
	 * @param Controller\Base $handler
	 * @param Request         $request
	 *
	 * @return void
	 */
	protected function triggerPostProcess(Controller\Base $handler, Request $request): void
	{
		if ($request->isAjax()) {
			$handler->postProcessAjax();
			return;
		}
		$handler->postProcess();
	}
}
