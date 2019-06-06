<?php
/**
 * The file contains: Base controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Base controller class.
 */
class Viewer extends \SmartyBC
{
	const DEFAULTLAYOUT = 'Default';

	public static $currentLayout;

	/**
	 * Constructor - Sets the templateDir and compileDir for the Smarty files.
	 *
	 * @param <String> - $media Layout/Media name
	 */
	public function __construct($media = '')
	{
		parent::__construct();

		self::$currentLayout = self::getLayoutName();
		$templatesDir = YF_ROOT . \DIRECTORY_SEPARATOR . 'layouts' . \DIRECTORY_SEPARATOR . self::getLayoutName();
		$compileDir = YF_ROOT . \DIRECTORY_SEPARATOR . 'cache' . \DIRECTORY_SEPARATOR . 'layouts' . \DIRECTORY_SEPARATOR . self::getLayoutName();

		if (!file_exists($compileDir)) {
			mkdir($compileDir, 0777, true);
		}
		$this->setTemplateDir([$templatesDir]);
		$this->setCompileDir($compileDir);
	}

	/**
	 * Function to return for default layout name.
	 *
	 * @return string - Default Layout Name
	 */
	public static function getLayoutName(): string
	{
		return Config::$theme ?? self::DEFAULTLAYOUT;
	}

	/**
	 * Static function to get the Instance of the Class Object.
	 *
	 * @param <String> $media Layout/Media
	 *
	 * @return Viewer instance
	 */
	public static function getInstance(string $media = '')
	{
		return new self($media);
	}

	/**
	 * Function to display/fetch the smarty file contents.
	 *
	 * @param string $templateName
	 * @param string $moduleName
	 * @param bool   $fetch
	 *
	 * @return string|true - html data
	 */
	public function view(string $templateName, string $moduleName = '', bool $fetch = false)
	{
		$templatePath = $this->getTemplatePath($templateName, $moduleName);
		$templateFound = $this->templateExists($templatePath);
		if ($templateFound) {
			if ($fetch) {
				return $this->fetch($templatePath);
			}
			$this->display($templatePath);
			return true;
		}
		throw new AppException("LBL_FILE_TEMPLATE_NOT_FOUND||{$templatePath}");
	}

	/**
	 * Function to get the module specific template path for a given template.
	 *
	 * @param string $templateName
	 * @param string $moduleName
	 *
	 * @return string - Module specific template path if exists, otherwise default template path for the given template name
	 */
	public function getTemplatePath(string $templateName, string $moduleName = ''): string
	{
		foreach ($this->getTemplateDir() as $templateDir) {
			$tpl = 'modules' . \DIRECTORY_SEPARATOR . $moduleName . \DIRECTORY_SEPARATOR . $templateName;
			$completeFilePath = $templateDir . $tpl;
			if (!empty($moduleName) && file_exists($completeFilePath)) {
				return $tpl;
			}
			$filePath = 'modules' . \DIRECTORY_SEPARATOR . 'Base' . \DIRECTORY_SEPARATOR . $templateName;
			if (!file_exists($templateDir . $filePath)) {
				throw new AppException('Template not found: ' . $filePath);
			}
		}
		return $filePath;
	}
}
