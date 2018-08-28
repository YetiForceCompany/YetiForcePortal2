<?php
/**
 * Users view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App;
use App\Session;

abstract class Index extends \App\Controller
{
	protected $viewer = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginRequired()
	{
		return true;
	}

	public function checkPermission(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$userInstance = \App\User::getUser();
		$modulePermission = $userInstance->isPermitted($moduleName);
		if (!$modulePermission) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	public function preProcess(\App\Request $request, $display = true)
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
	public function getViewer(\App\Request $request)
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

	public function getPageTitle(\App\Request $request)
	{
		$title = '';
		$moduleName = $request->getModule(false);
		if ($request->get('view') !== 'Login' && $moduleName !== 'Users') {
			$title = App\Language::translateModule($moduleName);
			$pageTitle = $this->getBreadcrumbTitle($request);
			if ($pageTitle) {
				$title .= ' - ' . $pageTitle;
			}
		}
		return $title;
	}

	public function getBreadcrumbTitle(App\Request $request)
	{
		if (!empty($this->pageTitle)) {
			return $this->pageTitle;
		}
		return false;
	}

	//Note : To get the right hook for immediate parent in PHP,
	// specially in case of deep hierarchy
	//TODO: Need to revisit this.
	/* function preProcessParentTplName(App\Request $request) {
	  return parent::preProcessTplName($request);
	  } */

	public function convertScripts($fileNames, $fileExtension)
	{
		$scriptsInstances = [];

		foreach ($fileNames as $fileName) {
			$script = new \App\Script();
			$script->set('type', $fileExtension);
			// external javascript source file handling
			if (strpos($fileName, 'http://') === 0 || strpos($fileName, 'https://') === 0) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
				continue;
			}
			$minFilePath = str_replace('.' . $fileExtension, '.min.' . $fileExtension, $fileName);
			if (\App\Config::getBoolean('minScripts') && file_exists($minFilePath)) {
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
		if (stripos($url, '://') === false && $fs = @filemtime($url)) {
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
	public function getHeaderCss(\App\Request $request)
	{
		$cssFileNames = [
			YF_ROOT_WWW . 'libraries/bootstrap/dist/css/bootstrap.css',
			YF_ROOT_WWW . 'libraries/chosen-js/chosen.css',
			YF_ROOT_WWW . 'libraries/bootstrap-chosen/bootstrap-chosen.css',
			YF_ROOT_WWW . 'libraries/jQuery-Validation-Engine/css/validationEngine.jquery.css',
			YF_ROOT_WWW . 'libraries/select2/dist/css/select2.css',
			YF_ROOT_WWW . 'libraries/select2-theme-bootstrap4/dist/select2-bootstrap.css',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/icons/userIcons.css',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/styles.css',
			YF_ROOT_WWW . 'libraries/datatables.net-bs4/css/dataTables.bootstrap4.css',
			YF_ROOT_WWW . 'libraries/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
			YF_ROOT_WWW . 'libraries/bootstrap-daterangepicker/daterangepicker.css',
			YF_ROOT_WWW . 'libraries/clockpicker/dist/bootstrap-clockpicker.css',
		];

		$headerCssInstances = $this->convertScripts($cssFileNames, 'css');
		return $headerCssInstances;
	}

	protected function preProcessDisplay(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		if (Session::has('systemError')) {
			$viewer->assign('ERRORS', Session::get('systemError'));
			unset($_SESSION['systemError']);
		}
		$viewer->view($this->preProcessTplName($request), $request->getModule());
	}

	protected function preProcessTplName(\App\Request $request)
	{
		return 'Header.tpl';
	}

	public function postProcess(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts($request));

		if (\App\Config::getBoolean('debugApi') && Session::has('debugApi') && Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', Session::get('debugApi'));
			$viewer->view('DebugApi.tpl');
			Session::set('debugApi', false);
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
	public function getFooterScripts(\App\Request $request)
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
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-regular/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-solid/index.js',
			YF_ROOT_WWW . 'libraries/@fortawesome/fontawesome-free-brands/index.js',
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
			YF_ROOT_WWW . 'libraries/clockpicker/dist/bootstrap-clockpicker.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/BaseValidator.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/FieldValidator.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/helper.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Field.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Connector.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/app.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/Header.js',
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/$action.js",
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/$moduleName/resources/$action.js",
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		return $jsScriptInstances;
	}
}
