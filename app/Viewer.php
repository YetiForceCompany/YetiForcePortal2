<?php
/**
 * The file contains: Base controller class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Base controller class.
 */
class Viewer extends \Smarty
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
		$templatesDir = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'layouts' . \DIRECTORY_SEPARATOR . self::getLayoutName();
		$customTemplate = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'custom' . \DIRECTORY_SEPARATOR . 'layouts' . \DIRECTORY_SEPARATOR . self::getLayoutName();
		$compileDir = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'cache' . \DIRECTORY_SEPARATOR . 'layouts' . \DIRECTORY_SEPARATOR . self::getLayoutName();

		if (!file_exists($compileDir)) {
			mkdir($compileDir, 0777, true);
		}
		$this->setTemplateDir([$customTemplate, $templatesDir]);
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
		throw new Exceptions\AppException("LBL_FILE_TEMPLATE_NOT_FOUND||{$templatePath}");
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
			$filePath = 'modules' . \DIRECTORY_SEPARATOR . $moduleName . \DIRECTORY_SEPARATOR . $templateName;
			$completeFilePath = $templateDir . $filePath;
			if (!empty($moduleName) && file_exists($completeFilePath)) {
				break;
			}
			$filePath = 'modules' . \DIRECTORY_SEPARATOR . 'Base' . \DIRECTORY_SEPARATOR . $templateName;
			if (file_exists($templateDir . $filePath)) {
				break;
			}
		}
		return $filePath;
	}

	/**
	 * Truncating plain text and adding a button showing all the text.
	 *
	 * @param string $text
	 * @param int    $length
	 * @param bool   $showIcon
	 *
	 * @return string
	 */
	public static function truncateText(string $text, int $length, bool $showIcon = false): string
	{
		if (\mb_strlen($text) < $length) {
			return $text;
		}
		$teaser = TextParser::textTruncate($text, $length);
		$text = nl2br($text);
		if ($showIcon) {
			$btn = '<span class="mdi mdi-overscan"></span>';
		} else {
			$btn = \App\Language::translate('LBL_MORE_BTN');
		}
		return "<div class=\"js-more-content\"><span class=\"teaserContent\">$teaser</span><span class=\"fullContent d-none\">$text</span><span class=\"text-right mb-1\"><a class=\"pt-0 js-more\">{$btn}</a></span></div>";
	}
}
