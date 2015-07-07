<?php

/**
 * Abstract View Controller Class
 */
abstract class Base_View_Base extends Core_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function getViewer(Core_Request $request) {
		if (!$this->viewer) {
			$viewer = new Core_Viewer();
			$this->viewer = $viewer;
		}
		return $this->viewer;
	}

	public function getPageTitle(Core_Request $request) {
		$title = $request->getModule();
		return $title;
	}

	public function preProcess(Core_Request $request, $display = true) {
		$module = $request->getModule();
		
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE', $module);
		$viewer->assign('PAGETITLE', $this->getPageTitle($request));
		$viewer->assign('HEADER_SCRIPTS', $this->getHeaderScripts($request));
		$viewer->assign('STYLES', $this->getHeaderCss($request));
		$viewer->assign('JSLANGUAGE', $this->getJSLanguageStrings($module));
		$viewer->assign('LANGUAGE', Core_Language::getLanguage());
		if ($display) {
			$this->preProcessDisplay($request);
		}
	}

	protected function preProcessTplName(Core_Request $request) {
		return 'Header.tpl';
	}

	//Note : To get the right hook for immediate parent in PHP,
	// specially in case of deep hierarchy
	//TODO: Need to revisit this.
	/* function preProcessParentTplName(Core_Request $request) {
	  return parent::preProcessTplName($request);
	  } */

	protected function preProcessDisplay(Core_Request $request) {
		$viewer = $this->getViewer($request);
		$displayed = $viewer->view($this->preProcessTplName($request), $request->getModule());
	}

	function postProcess(Core_Request $request) {
		$viewer = $this->getViewer($request);
		$viewer->assign('FOOTER_SCRIPTS', $this->getFooterScripts($request));
		$viewer->view('Footer.tpl');
	}

	/**
	 * Retrieves css styles that need to loaded in the page
	 * @param Core_Request $request - request model
	 * @return <array> - array of Core_Script
	 */
	function getHeaderCss(Core_Request $request) {
		$cssFileNames = ['libraries/Bootstrap/css/bootstrap.css'];
		$headerCssInstances = $this->convertScripts($cssFileNames, 'css');
		return $headerCssInstances;
	}

	/**
	 * Retrieves headers scripts that need to loaded in the page
	 * @param Core_Request $request - request model
	 * @return <array> - array of Core_Script
	 */
	function getHeaderScripts(Core_Request $request) {
		$headerScriptInstances = [];
		$jsScriptInstances = $this->convertScripts($headerScriptInstances, 'js');
		return $jsScriptInstances;
	}

	function getFooterScripts(Core_Request $request) {
		$jsFileNames = [];
		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		return $jsScriptInstances;
	}

	function convertScripts($fileNames, $fileExtension) {
		$scriptsInstances = [];
		foreach ($fileNames as $fileName) {
			$script = new Core_Script();

			// external javascript source file handling
			if (strpos($fileName, 'http://') === 0 || strpos($fileName, 'https://') === 0) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
				continue;
			}

			$minFilePath = str_replace('.' . $fileExtension, '.min' . $fileExtension, $fileName);

			if (Config::get('minScripts') && file_exists($minFilePath)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($minFilePath));
			} else if (file_exists($fileName)) {
				$scriptsInstances[] = $script->set('src', self::resourceUrl($fileName));
			}
		}
		return $scriptsInstances;
	}

	/**
	 * Function returns the Client side language string
	 * @param Core_Request $request
	 */
	function getJSLanguageStrings($moduleName) {
		return Core_Language::export($moduleName, 'jsLang');
	}


	function resourceUrl($url) {
		if (stripos($url, '://') === false && $fs = @filemtime($url)) {
			$url = $url . '?s=' . $fs;
		}
		return $url;
	}

}
