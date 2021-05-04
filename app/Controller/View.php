<?php
/**
 * Controller class for views.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Controller;

use App\Purifier;
use App\Request;

/**
 * Controller class for views.
 */
abstract class View extends Base
{
	/**
	 * Viewer object.
	 *
	 * @var \App\Viewer
	 */
	protected $viewer;

	/**
	 * Module name.
	 *
	 * @var string
	 */
	protected $moduleName;

	/**
	 * Construct.
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->moduleName = $request->getModule();
		$this->viewer = new \App\Viewer();
		$this->viewer->assign('MODULE_NAME', $this->getModuleNameFromRequest($this->request));
		$this->viewer->assign('VIEW', $this->request->getByType('view', Purifier::ALNUM));
		$this->viewer->assign('USER', \App\User::getUser());
		$this->viewer->assign('ACTION_NAME', $this->request->getAction());
	}

	public function checkPermission()
	{
		$this->getModuleNameFromRequest($this->request);
		$userInstance = \App\User::getUser();
		$modulePermission = $userInstance->isPermitted($this->moduleName);
		if (!$modulePermission) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	public function preProcess($display = true)
	{
		$this->viewer->assign('PAGETITLE', $this->getPageTitle());
		$this->viewer->assign('STYLES', $this->getHeaderCss());
		$this->viewer->assign('LANGUAGE', \App\Language::getLanguage());
		$this->viewer->assign('LANG', \App\Language::getShortLanguageName());
		$this->viewer->assign('USER', \App\User::getUser());
		if ($display) {
			$this->preProcessDisplay();
		}
	}

	/**
	 * Get page title.
	 *
	 * @return string
	 */
	public function getPageTitle(): string
	{
		$title = '';
		if ('Login' !== $this->request->getByType('view', Purifier::ALNUM) && 'Users' !== $this->moduleName) {
			$title = \App\Language::translateModule($this->moduleName);
			$pageTitle = $this->getBreadcrumbTitle();
			if ($pageTitle) {
				$title .= ' - ' . $pageTitle;
			}
		}
		return $title;
	}

	public function getBreadcrumbTitle()
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
				\App\Log::warning('Asset not found: ' . $fileName);
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
	 * @return \App\Script[]
	 */
	public function getHeaderCss()
	{
		$cssFileNames = [
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free/css/all.css',
			PUBLIC_DIRECTORY . 'libraries/@mdi/font/css/materialdesignicons.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap/dist/css/bootstrap.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-material-design/dist/css/bootstrap-material-design.css',
			PUBLIC_DIRECTORY . 'libraries/chosen-js/chosen.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-chosen/bootstrap-chosen.css',
			PUBLIC_DIRECTORY . 'libraries/jQuery-Validation-Engine/css/validationEngine.jquery.css',
			PUBLIC_DIRECTORY . 'libraries/select2/dist/css/select2.css',
			PUBLIC_DIRECTORY . 'libraries/select2-theme-bootstrap4/dist/select2-bootstrap.css',
			PUBLIC_DIRECTORY . 'libraries/datatables.net-bs4/css/dataTables.bootstrap4.css',
			PUBLIC_DIRECTORY . 'libraries/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-daterangepicker/daterangepicker.css',
			PUBLIC_DIRECTORY . 'libraries/clockpicker/dist/bootstrap4-clockpicker.css',
			PUBLIC_DIRECTORY . 'libraries/jstree-bootstrap-theme/dist/themes/proton/style.css',
			PUBLIC_DIRECTORY . 'libraries/jstree/dist/themes/default/style.css',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/core/dist/PNotify.css',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/confirm/dist/PNotifyConfirm.css',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/bootstrap4/dist/PNotifyBootstrap4.css',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/mobile/dist/PNotifyMobile.css',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/desktop/dist/PNotifyDesktop.css',
			PUBLIC_DIRECTORY . 'layouts/resources/icons/adminIcon.css',
			PUBLIC_DIRECTORY . 'layouts/resources/icons/additionalIcons.css',
			PUBLIC_DIRECTORY . 'layouts/resources/icons/yfm.css',
			PUBLIC_DIRECTORY . 'layouts/resources/icons/yfi.css',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
		];
		return $this->convertScripts($cssFileNames, 'css');
	}

	protected function preProcessDisplay()
	{
		if (\App\Session::has('systemError')) {
			$this->viewer->assign('ERRORS', \App\Session::get('systemError'));
			\App\Session::unset('systemError');
		}
		$this->viewer->view($this->preProcessTplName(), $this->moduleName);
	}

	/** {@inheritdoc}  */
	protected function preProcessTplName(): string
	{
		return 'Header.tpl';
	}

	/**
	 * Get process tpl name.
	 *
	 * @return string
	 */
	protected function processTplName(): string
	{
		return $this->request->getAction() . '/Index.tpl';
	}

	/** {@inheritdoc}  */
	protected function postProcessTplName(): string
	{
		return 'Footer.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	public function postProcess()
	{
		$this->viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts());
		if (\App\Config::$debugApi && \App\Session::has('debugApi') && \App\Session::get('debugApi')) {
			$this->viewer->assign('DEBUG_API', \App\Session::get('debugApi'));
			$this->viewer->view('DebugApi.tpl', $this->moduleName);
			\App\Session::set('debugApi', false);
		}
		$this->viewer->view($this->postProcessTplName(), $this->moduleName);
	}

	/**
	 * Scripts.
	 *
	 * @return \App\Script[]
	 */
	public function getFooterScripts()
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		$languageHandlerShortName = \App\Language::getShortLanguageName();
		$fileName = "~libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-$languageHandlerShortName.js";
		if (!file_exists($fileName)) {
			$fileName = PUBLIC_DIRECTORY . 'libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-en.js';
		}
		$jsFileNames = [
			PUBLIC_DIRECTORY . 'libraries/jquery/dist/jquery.js',
			PUBLIC_DIRECTORY . 'libraries/jquery.class.js/jquery.class.js',
			PUBLIC_DIRECTORY . 'libraries/block-ui/jquery.blockUI.js',
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome/index.js',
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free-regular/index.js',
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free-solid/index.js',
			PUBLIC_DIRECTORY . 'libraries/@fortawesome/fontawesome-free-brands/index.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/core/dist/PNotify.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/mobile/dist/PNotifyMobile.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/desktop/dist/PNotifyDesktop.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/confirm/dist/PNotifyConfirm.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/bootstrap4/dist/PNotifyBootstrap4.js',
			PUBLIC_DIRECTORY . 'libraries/@pnotify/font-awesome5/dist/PNotifyFontAwesome5.js',
			PUBLIC_DIRECTORY . 'libraries/popper.js/dist/umd/popper.js',
			PUBLIC_DIRECTORY . 'libraries/bootstrap/dist/js/bootstrap.js',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-daterangepicker/daterangepicker.js',
			PUBLIC_DIRECTORY . 'libraries/bootstrap-material-design/dist/js/bootstrap-material-design.js',
			PUBLIC_DIRECTORY . 'libraries/bootbox/dist/bootbox.min.js',
			PUBLIC_DIRECTORY . 'libraries/chosen-js/chosen.jquery.js',
			PUBLIC_DIRECTORY . 'libraries/select2/dist/js/select2.full.js',
			PUBLIC_DIRECTORY . 'libraries/moment/min/moment.min.js',
			PUBLIC_DIRECTORY . 'libraries/inputmask/dist/jquery.inputmask.bundle.js',
			PUBLIC_DIRECTORY . 'libraries/datatables.net/js/jquery.dataTables.js',
			PUBLIC_DIRECTORY . 'libraries/datatables.net-bs4/js/dataTables.bootstrap4.js',
			PUBLIC_DIRECTORY . 'libraries/datatables.net-responsive/js/dataTables.responsive.js',
			PUBLIC_DIRECTORY . 'libraries/datatables.net-responsive-bs4/js/responsive.bootstrap4.js',
			PUBLIC_DIRECTORY . 'libraries/jQuery-Validation-Engine/js/jquery.validationEngine.js',
			$fileName,
			PUBLIC_DIRECTORY . 'libraries/jstree/dist/jstree.js',
			PUBLIC_DIRECTORY . 'libraries/clockpicker/dist/bootstrap4-clockpicker.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/BaseValidator.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/validator/FieldValidator.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/helper.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Field.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Connector.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/app.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/Fields.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/resources/ProgressIndicator.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/Header.js',
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/{$action}.js",
			PUBLIC_DIRECTORY . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js",
		];
		return $this->convertScripts($jsFileNames, 'js');
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateRequest()
	{
		$this->request->validateReadAccess();
	}

	/**
	 * {@inheritdoc}
	 */
	public function postProcessAjax()
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcessAjax()
	{
	}

	/**
	 * Get module name from request.
	 *
	 * @return string
	 */
	private function getModuleNameFromRequest(): string
	{
		if (empty($this->moduleName)) {
			$this->moduleName = $this->request->getModule();
		}
		return $this->moduleName;
	}
}
