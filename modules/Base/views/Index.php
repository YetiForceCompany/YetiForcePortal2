<?php
/**
 * Users view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;

use Core;
use Core\Session;

abstract class Index extends Core\Controller
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

	function checkPermission(Core\Request $request)
	{
		$moduleName = $request->getModule();
		$userInstance = Core\User::getUser();
		$modulePermission = $userInstance->isPermitted($moduleName);
		if (!$modulePermission) {
			throw new \AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	public function getViewer(Core\Request $request)
	{
		if (!$this->viewer) {
			$moduleName = $request->getModule();

			$viewer = new Core\Viewer();
			$viewer->assign('MODULE_NAME', $moduleName);
			$viewer->assign('ACTION_NAME', $request->getAction());
			$this->viewer = $viewer;
		}
		return $this->viewer;
	}

	public function getPageTitle(Core\Request $request)
	{
		return $request->getAction();
	}

	public function preProcess(Core\Request $request, $display = true)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('PAGETITLE', $this->getPageTitle($request));
		$viewer->assign('HEADER_SCRIPTS', $this->getHeaderScripts($request));
		$viewer->assign('STYLES', $this->getHeaderCss($request));
		$viewer->assign('LANGUAGE', Core\Language::getLanguage());
		$viewer->assign('LANG', Core\Language::getShortLanguageName());
		$viewer->assign('USER', Core\User::getUser());
		if ($display) {
			$this->preProcessDisplay($request);
		}
	}

	protected function preProcessTplName(Core\Request $request)
	{
		return 'Header.tpl';
	}

	//Note : To get the right hook for immediate parent in PHP,
	// specially in case of deep hierarchy
	//TODO: Need to revisit this.
	/* function preProcessParentTplName(Core\Request $request) {
	  return parent::preProcessTplName($request);
	  } */

	protected function preProcessDisplay(Core\Request $request)
	{
		$viewer = $this->getViewer($request);
		if (Session::has('systemError')) {
			$viewer->assign('ERRORS', Session::get('systemError'));
			unset($_SESSION['systemError']);
		}
		$viewer->view($this->preProcessTplName($request), $request->getModule());
	}

	public function postProcess(Core\Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts($request));

		if (\Config::getBoolean('debugApi') && Session::has('debugApi') && Session::get('debugApi')) {
			$viewer->assign('DEBUG_API', Session::get('debugApi'));
			$viewer->view('DebugApi.tpl');
			Session::set('debugApi', false);
		}
		$viewer->view('Footer.tpl');
	}

	/**
	 * Retrieves css styles that need to loaded in the page
	 * @param Core\Request $request - request model
	 * @return Core\Script[]
	 */
	public function getHeaderCss(Core\Request $request)
	{
		$cssFileNames = [
			'libraries/Scripts/pace/pace.css',
			'libraries/Bootstrap/css/bootstrap.css',
			'libraries/Scripts/chosen/chosen.css',
			'layouts/' . Core\Viewer::getLayoutName() . '/skins/icons/userIcons.css',
			'layouts/' . Core\Viewer::getLayoutName() . '/skins/basic/styles.css',
			'libraries/FontAwesome/css/font-awesome.css',
			'libraries/Datatables/media/css/jquery.dataTables_themeroller.css',
			'libraries/Datatables/plugins/integration/bootstrap/3/dataTables.bootstrap.css',
		];

		$headerCssInstances = $this->convertScripts($cssFileNames, 'css');
		return $headerCssInstances;
	}

	/**
	 * Retrieves headers scripts that need to loaded in the page
	 * @param Core\Request $request - request model
	 * @return <array> - array of Core\Script
	 */
	public function getHeaderScripts(Core\Request $request)
	{
		$headerScriptInstances = [
			'libraries/Scripts/pace/pace.js',
		];
		$jsScriptInstances = $this->convertScripts($headerScriptInstances, 'js');
		return $jsScriptInstances;
	}

	/**
	 * Scripts
	 * @param \Core\Request $request
	 * @return \Core\Script[]
	 */
	public function getFooterScripts(Core\Request $request)
	{
		$moduleName = $request->getModule();
		$action = $request->getAction();
		$jsFileNames = [
			'libraries/Scripts/jquery/jquery.js',
			'libraries/Scripts/jquery/jquery.class.js',
			'libraries/Scripts/jquery-pjax/jquery.pjax.js',
			'libraries/Bootstrap/js/bootstrap.js',
			'libraries/Scripts/chosen/chosen.jquery.js',
			'libraries/Datatables/media/js/jquery.dataTables.js',
			'libraries/Datatables/plugins/integration/bootstrap/3/dataTables.bootstrap.js',
			'layouts/' . Core\Viewer::getLayoutName() . '/resources/app.js',
			'layouts/' . Core\Viewer::getLayoutName() . '/resources/Connector.js',
			'layouts/' . Core\Viewer::getLayoutName() . "/modules/Base/resources/Header.js",
			'layouts/' . Core\Viewer::getLayoutName() . "/modules/Base/resources/$action.js",
			'layouts/' . Core\Viewer::getLayoutName() . "/modules/$moduleName/resources/$action.js",
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		return $jsScriptInstances;
	}

	public function convertScripts($fileNames, $fileExtension)
	{
		$scriptsInstances = [];

		foreach ($fileNames as $fileName) {
			$script = new Core\Script();
			$script->set('type', $fileExtension);
			// external javascript source file handling
			if (strpos($fileName, 'http://') === 0 || strpos($fileName, 'https://') === 0) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
				continue;
			}
			$minFilePath = str_replace('.' . $fileExtension, '.min.' . $fileExtension, $fileName);
			if (\Config::getBoolean('minScripts') && file_exists($minFilePath)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($minFilePath));
			} else if (file_exists($fileName)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
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
}
