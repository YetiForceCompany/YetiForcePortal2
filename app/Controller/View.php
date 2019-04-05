<?php
/**
 * Controller class for views.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Controller;

use App\Request;

abstract class View extends Base
{
	protected $viewer = false;

	public function checkPermission(Request $request)
	{
		$moduleName = $request->getModule();
		$userInstance = \App\User::getUser();
		$modulePermission = $userInstance->isPermitted($moduleName);
		if (!$modulePermission) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	public function preProcess(Request $request, $display = true)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('PAGETITLE', $this->getPageTitle($request));
		$viewer->assign('STYLES', $this->getHeaderCss($request));
		$viewer->assign('LANGUAGE', \App\Language::getLanguage());
		$viewer->assign('LANG', \App\Language::getShortLanguageName());
		$viewer->assign('USER', \App\User::getUser());
		if ($display) {
			$this->preProcessDisplay($request);
		}
	}

	/**
	 * Get viewer.
	 *
	 * @param \App\Request $request
	 *
	 * @return \App\Viewer
	 */
	public function getViewer(Request $request)
	{
		if (!$this->viewer) {
			$moduleName = $request->getModule();

			$viewer = new \App\Viewer();
			$userInstance = \App\User::getUser();
			$viewer->assign('MODULE_NAME', $moduleName);
			$viewer->assign('VIEW', $request->get('view'));
			$viewer->assign('USER', $userInstance);
			$viewer->assign('ACTION_NAME', $request->getAction());
			$this->viewer = $viewer;
		}
		return $this->viewer;
	}

	public function getPageTitle(Request $request)
	{
		$title = '';
		$moduleName = $request->getModule(false);
		if ('Login' !== $request->get('view') && 'Users' !== $moduleName) {
			$title = \App\Language::translateModule($moduleName);
			$pageTitle = $this->getBreadcrumbTitle($request);
			if ($pageTitle) {
				$title .= ' - ' . $pageTitle;
			}
		}
		return $title;
	}

	public function getBreadcrumbTitle(Request $request)
	{
		if (!empty($this->pageTitle)) {
			return $this->pageTitle;
		}
		return false;
	}

	public function convertScripts($fileNames, $fileExtension)
	{
		$scriptsInstances = [];

		foreach ($fileNames as $fileName) {
			$script = new \App\Script();
			$script->set('type', $fileExtension);
			// external javascript source file handling
			if (0 === strpos($fileName, 'http://') || 0 === strpos($fileName, 'https://')) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
				continue;
			}
			$minFilePath = str_replace('.' . $fileExtension, '.min.' . $fileExtension, $fileName);
			if (\App\Config::$minScripts && file_exists($minFilePath)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($minFilePath));
			} elseif (file_exists($fileName)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
			} else {
				\App\Log::message('Asset not found: ' . $fileName, 'WARNING');
			}
		}
		return $scriptsInstances;
	}

	public function resourceUrl($url)
	{
		if (false === stripos($url, '://') && $fs = @filemtime($url)) {
			$url = $url . '?s=' . $fs;
		}
		return $url;
	}

	/**
	 * Retrieves css styles that need to loaded in the page.
	 *
	 * @param \App\Request $request - request model
	 *
	 * @return \App\Script[]
	 */
	public function getHeaderCss(Request $request)
	{
		$cssFileNames = [
			YF_ROOT_WWW . 'libraries/bootstrap/dist/css/bootstrap.css',
			YF_ROOT_WWW . 'libraries/chosen-js/chosen.css',
			YF_ROOT_WWW . 'libraries/bootstrap-chosen/bootstrap-chosen.css',
			YF_ROOT_WWW . 'libraries/jQuery-Validation-Engine/css/validationEngine.jquery.css',
			YF_ROOT_WWW . 'libraries/select2/dist/css/select2.css',
			YF_ROOT_WWW . 'libraries/select2-theme-bootstrap4/dist/select2-bootstrap.css',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/icons/userIcons.css',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
			YF_ROOT_WWW . 'libraries/datatables.net-bs4/css/dataTables.bootstrap4.css',
			YF_ROOT_WWW . 'libraries/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
			YF_ROOT_WWW . 'libraries/bootstrap-daterangepicker/daterangepicker.css',
			YF_ROOT_WWW . 'libraries/clockpicker/dist/bootstrap-clockpicker.css',
		];

		return $this->convertScripts($cssFileNames, 'css');
	}

	protected function preProcessDisplay(Request $request)
	{
		$viewer = $this->getViewer($request);
		if (\App\Session::has('systemError')) {
			$viewer->assign('ERRORS', \App\Session::get('systemError'));
			unset($_SESSION['systemError']);
		}
		$viewer->view($this->preProcessTplName($request), $request->getModule());
	}

	protected function preProcessTplName(Request $request)
	{
		return 'Header.tpl';
	}

	/**
	 * Get process tpl name.
	 *
	 * @param \App\Request $request
	 *
	 * @return string
	 */
	public function processTplName(Request $request = null): string
	{
		return $request->getAction() . '/Index.tpl';
	}

	public function postProcess(Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts($request));

		if (\App\Config::$debugApi && \App\Session::has('debugApi') && \App\Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', \App\Session::get('debugApi'));
			$viewer->view('DebugApi.tpl');
			\App\Session::set('debugApi', false);
		}
		$viewer->view('Footer.tpl');
	}

	/**
	 * Scripts.
	 *
	 * @param \App\Request $request
	 *
	 * @return \App\Script[]
	 */
	public function getFooterScripts(Request $request)
	{
		$moduleName = $request->getModule();
		$action = $request->getAction();
		$languageHandlerShortName = \App\Language::getShortLanguageName();
		$fileName = "~libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-$languageHandlerShortName.js";
		if (!file_exists($fileName)) {
			$fileName = YF_ROOT_WWW . 'libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-en.js';
		}
		$jsFileNames = [
			YF_ROOT_WWW . 'libraries/jquery/dist/jquery.js',
			YF_ROOT_WWW . 'libraries/jquery.class.js/jquery.class.js',
			YF_ROOT_WWW . 'libraries/block-ui/jquery.blockUI.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-regular/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-solid/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-brands/index.js',
			YF_ROOT_WWW . 'libraries/popper.js/dist/umd/popper.js',
			YF_ROOT_WWW . 'libraries/bootstrap/dist/js/bootstrap.js',
			YF_ROOT_WWW . 'libraries/chosen-js/chosen.jquery.js',
			YF_ROOT_WWW . 'libraries/select2/dist/js/select2.full.js',
			YF_ROOT_WWW . 'libraries/moment/min/moment.min.js',
			YF_ROOT_WWW . 'libraries/inputmask/dist/jquery.inputmask.bundle.js',
			YF_ROOT_WWW . 'libraries/bootstrap-daterangepicker/daterangepicker.js',
			YF_ROOT_WWW . 'libraries/datatables.net/js/jquery.dataTables.js',
			YF_ROOT_WWW . 'libraries/datatables.net-bs4/js/dataTables.bootstrap4.js',
			YF_ROOT_WWW . 'libraries/datatables.net-responsive/js/dataTables.responsive.js',
			YF_ROOT_WWW . 'libraries/datatables.net-responsive-bs4/js/responsive.bootstrap4.js',
			YF_ROOT_WWW . 'libraries/jQuery-Validation-Engine/js/jquery.validationEngine.js',
			$fileName,
			YF_ROOT_WWW . 'libraries/jstree/dist/jstree.js',
			YF_ROOT_WWW . 'libraries/clockpicker/dist/bootstrap-clockpicker.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/BaseValidator.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/FieldValidator.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/helper.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Field.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Connector.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/app.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Fields.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/ProgressIndicator.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/Header.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/$action.js",
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/$moduleName/resources/$action.js",
		];

		return $this->convertScripts($jsFileNames, 'js');
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateRequest(Request $request)
	{
		//$request->validateReadAccess();
	}

	/**
	 * {@inheritdoc}
	 */
	public function postProcessAjax(Request $request)
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcessAjax(Request $request)
	{
	}
}
