<?php
/**
 * Controller class for views.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

use App\Purifier;
use App\Request;

/**
 * Controller class for views.
 */
abstract class View extends Base
{
	/** @var \App\Viewer Viewer object. */
	protected $viewer;

	/** @var string Module name. */
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

	public function preProcess($display = true): void
	{
		$this->viewer->assign('PAGE_TITLE', $this->getPageTitle());
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

	/**
	 * Convert scripts path.
	 *
	 * @param string[] $fileNames
	 * @param string   $fileExtension
	 *
	 * @return array
	 */
	public function convertScripts($fileNames, $fileExtension): array
	{
		$scriptsInstances = [];
		foreach ($fileNames as $fileName) {
			$path = ROOT_DIRECTORY . "/public_html/$fileName";
			$script = new \App\Script();
			$script->set('type', $fileExtension);
			$minFilePath = str_replace('.' . $fileExtension, '.min.' . $fileExtension, $fileName);
			if (\App\Config::$minScripts && file_exists($minFilePath)) {
				$scriptsInstances[] = $script->set('src', PUBLIC_DIRECTORY . $minFilePath . self::getTime($path));
			} elseif (file_exists($path)) {
				$scriptsInstances[] = $script->set('src', PUBLIC_DIRECTORY . $fileName . self::getTime($path));
			} else {
				\App\Log::warning('File not found: ' . $path);
			}
		}
		return $scriptsInstances;
	}

	/**
	 * Gets file modification time.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public static function getTime(string $path): string
	{
		$url = '';
		if ($fs = filemtime($path)) {
			$url = '?s=' . $fs;
		}
		return $url;
	}

	/**
	 * Retrieves css styles that need to loaded in the page.
	 *
	 * @return \App\Script[]
	 */
	public function getHeaderCss(): array
	{
		return $this->convertScripts([
			'libraries/@fortawesome/fontawesome-free/css/all.css',
			'libraries/@mdi/font/css/materialdesignicons.css',
			'libraries/bootstrap/dist/css/bootstrap.css',
			'libraries/bootstrap-material-design/dist/css/bootstrap-material-design.css',
			'libraries/chosen-js/chosen.css',
			'libraries/bootstrap-chosen/bootstrap-chosen.css',
			'libraries/jQuery-Validation-Engine/css/validationEngine.jquery.css',
			'libraries/select2/dist/css/select2.css',
			'libraries/select2-theme-bootstrap4/dist/select2-bootstrap.css',
			'libraries/datatables.net-bs4/css/dataTables.bootstrap4.css',
			'libraries/datatables.net-responsive-bs4/css/responsive.bootstrap4.css',
			'libraries/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
			'libraries/bootstrap-daterangepicker/daterangepicker.css',
			'libraries/clockpicker/dist/bootstrap4-clockpicker.css',
			'libraries/jstree-bootstrap-theme/dist/themes/proton/style.css',
			'libraries/jstree/dist/themes/default/style.css',
			'libraries/@pnotify/core/dist/PNotify.css',
			'libraries/@pnotify/confirm/dist/PNotifyConfirm.css',
			'libraries/@pnotify/bootstrap4/dist/PNotifyBootstrap4.css',
			'libraries/@pnotify/mobile/dist/PNotifyMobile.css',
			'libraries/@pnotify/desktop/dist/PNotifyDesktop.css',
			'layouts/resources/icons/additionalIcons.css',
			'layouts/resources/icons/yfm.css',
			'layouts/resources/icons/yfi.css',
			'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/Main.css',
		], 'css');
	}

	protected function preProcessDisplay()
	{
		if (\App\Session::has('systemError')) {
			$this->viewer->assign('ERRORS', \App\Session::get('systemError'));
			\App\Session::unset('systemError');
		}
		$this->viewer->view($this->preProcessTplName(), $this->moduleName);
	}

	/**
	 * Get preprocess tpl name.
	 *
	 * @return string
	 */
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

	/** {@inheritdoc} */
	public function postProcess(): void
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
	public function getFooterScripts(): array
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		$languageHandlerShortName = \App\Language::getShortLanguageName();
		$fileName = "libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-$languageHandlerShortName.js";
		if (!file_exists(PUBLIC_DIRECTORY . $fileName)) {
			$fileName = 'libraries/jQuery-Validation-Engine/js/languages/jquery.validationEngine-en.js';
		}
		return $this->convertScripts([
			'libraries/jquery/dist/jquery.js',
			'libraries/jquery.class.js/jquery.class.js',
			'libraries/block-ui/jquery.blockUI.js',
			'libraries/@fortawesome/fontawesome/index.js',
			'libraries/@fortawesome/fontawesome-free-regular/index.js',
			'libraries/@fortawesome/fontawesome-free-solid/index.js',
			'libraries/@fortawesome/fontawesome-free-brands/index.js',
			'libraries/@pnotify/core/dist/PNotify.js',
			'libraries/@pnotify/mobile/dist/PNotifyMobile.js',
			'libraries/@pnotify/desktop/dist/PNotifyDesktop.js',
			'libraries/@pnotify/confirm/dist/PNotifyConfirm.js',
			'libraries/@pnotify/bootstrap4/dist/PNotifyBootstrap4.js',
			'libraries/@pnotify/font-awesome5/dist/PNotifyFontAwesome5.js',
			'libraries/popper.js/dist/umd/popper.js',
			'libraries/bootstrap/dist/js/bootstrap.js',
			'libraries/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
			'libraries/bootstrap-daterangepicker/daterangepicker.js',
			'libraries/bootstrap-material-design/dist/js/bootstrap-material-design.js',
			'libraries/bootbox/dist/bootbox.min.js',
			'libraries/chosen-js/chosen.jquery.js',
			'libraries/select2/dist/js/select2.full.js',
			'libraries/moment/min/moment.min.js',
			'libraries/inputmask/dist/jquery.inputmask.bundle.js',
			'libraries/datatables.net/js/jquery.dataTables.js',
			'libraries/datatables.net-bs4/js/dataTables.bootstrap4.js',
			'libraries/datatables.net-responsive/js/dataTables.responsive.js',
			'libraries/datatables.net-responsive-bs4/js/responsive.bootstrap4.js',
			'libraries/jQuery-Validation-Engine/js/jquery.validationEngine.js',
			$fileName,
			'libraries/jstree/dist/jstree.js',
			'libraries/clockpicker/dist/bootstrap4-clockpicker.js',
			'layouts/resources/validator/BaseValidator.js',
			'layouts/resources/validator/FieldValidator.js',
			'layouts/resources/helper.js',
			'layouts/resources/Field.js',
			'layouts/resources/Connector.js',
			'layouts/resources/app.js',
			'layouts/resources/Fields.js',
			'layouts/resources/ProgressIndicator.js',
			'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/Header.js',
			'layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/{$action}.js",
			'layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js",
		], 'js');
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateReadAccess();
	}

	/** {@inheritdoc} */
	public function postProcessAjax()
	{
	}

	/** {@inheritdoc} */
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
