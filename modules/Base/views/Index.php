<?php
/**
 * Users view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;

use Core;

abstract class Index extends Core\Controller
{

	public function loginRequired()
	{
		return true;
	}

	protected $viewer = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function getViewer(Core\Request $request)
	{
		if (!$this->viewer) {
			$viewer = new Core\Viewer();
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
		$module = $request->getModule();

		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_NAME', $module);
		$viewer->assign('ACTION_NAME', $request->getAction());
		$viewer->assign('PAGETITLE', $this->getPageTitle($request));
		$viewer->assign('HEADER_SCRIPTS', $this->getHeaderScripts($request));
		$viewer->assign('STYLES', $this->getHeaderCss($request));
		$viewer->assign('LANGUAGE', Core\Language::getLanguage());
		$viewer->assign('LANG', Core\Language::getShortLanguageName());
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
		if (isset($_SESSION['systemError'])) {
			$viewer->assign('ERRORS', $_SESSION['systemError']);
			unset($_SESSION['systemError']);
		}
		$viewer->view($this->preProcessTplName($request), $request->getModule());
	}

	public function postProcess(Core\Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts($request));
		$viewer->view('Footer.tpl');
	}

	/**
	 * Retrieves css styles that need to loaded in the page
	 * @param Core\Request $request - request model
	 * @return <array> - array of Core\Script
	 */
	public function getHeaderCss(Core\Request $request)
	{
		$cssFileNames = [
			'libraries/Bootstrap/css/bootstrap.css',
			'libraries/Bootstrap/css/bootstrap-theme.css',
			'layouts/' . Core\Viewer::getLayoutName() . '/skins/basic/styles.css',
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
		$headerScriptInstances = [];
		$jsScriptInstances = $this->convertScripts($headerScriptInstances, 'js');
		return $jsScriptInstances;
	}

	public function getFooterScripts(Core\Request $request)
	{
		$jsFileNames = [
			'libraries/Scripts/jquery/jquery.js',
			'libraries/Bootstrap/js/bootstrap.js',
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
