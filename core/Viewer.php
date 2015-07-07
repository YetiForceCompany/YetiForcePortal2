<?php

Core_Loader::import('libraries/Smarty/SmartyBC.class.php');

class Core_Viewer extends SmartyBC {

	const DEFAULTLAYOUT = 'main';

	static $currentLayout;

	/**
	 * Constructor - Sets the templateDir and compileDir for the Smarty files
	 * @param <String> - $media Layout/Media name
	 */
	public function __construct($media = '') {
		parent::__construct();

		self::$currentLayout = self::getLayoutName();
		$templatesDir = YF_PATH_BASE . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR. self::getLayoutName();
		$compileDir = YF_PATH_BASE . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR. self::getLayoutName();

		if (!file_exists($compileDir)) {
			mkdir($compileDir, 0777, true);
		}
		$this->setTemplateDir([$templatesDir]);
		$this->setCompileDir($compileDir);
	}

	/**
	 * Function to return for default layout name
	 * @return <String> - Default Layout Name
	 */
	public static function getLayoutName() {
		return self::DEFAULTLAYOUT;
	}

	/**
	 * Function to get the module specific template path for a given template
	 * @param <String> $templateName
	 * @param <String> $moduleName
	 * @return <String> - Module specific template path if exists, otherwise default template path for the given template name
	 */
	public function getTemplatePath($templateName, $moduleName = '') {
		foreach ($this->getTemplateDir() as $templateDir) {
			$tpl = 'modules'. DIRECTORY_SEPARATOR. $moduleName. DIRECTORY_SEPARATOR. $templateName;
			$completeFilePath = $templateDir. $tpl;
			if (!empty($moduleName) && file_exists($completeFilePath)) {
				return $tpl;
			} else {
				$filePath = "modules/Base/$templateName";
			}
		}
		return $filePath;
	}

	/**
	 * Function to display/fetch the smarty file contents
	 * @param <String> $templateName
	 * @param <String> $moduleName
	 * @param <Boolean> $fetch
	 * @return html data
	 */
	public function view($templateName, $moduleName = '', $fetch = false) {
		$templatePath = $this->getTemplatePath($templateName, $moduleName);
		$templateFound = $this->templateExists($templatePath);
		
		if ($templateFound) {
			if ($fetch) {
				return $this->fetch($templatePath);
			} else {
				$this->display($templatePath);
			}
			return true;
		}

		return false;
	}

	/**
	 * Static function to get the Instance of the Class Object
	 * @param <String> $media Layout/Media
	 * @return Core_Viewer instance
	 */
	static function getInstance($media = '') {
		$instance = new self($media);
		return $instance;
	}

}
