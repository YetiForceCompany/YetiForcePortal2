<?php
/**
 * A class that facilitates the use of resources.
 *
 * @package   App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Class Resources.
 */
class Resources
{
	/**
	 * Get path for resource.
	 *
	 * @param string $name
	 * @param string $moduleName
	 * @param string $type
	 *
	 * @return string
	 */
	public static function resourcePath(string $name, string $moduleName, string $type = 'images'): string
	{
		$filePath = PUBLIC_DIRECTORY . 'layouts' . \DIRECTORY_SEPARATOR . Viewer::getLayoutName() . \DIRECTORY_SEPARATOR . 'modules' . \DIRECTORY_SEPARATOR . $moduleName . \DIRECTORY_SEPARATOR . $type . \DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			return str_replace(\DIRECTORY_SEPARATOR, '/', $filePath);
		}
		$filePath = PUBLIC_DIRECTORY . 'layouts' . \DIRECTORY_SEPARATOR . Viewer::getLayoutName() . \DIRECTORY_SEPARATOR . 'skins' . \DIRECTORY_SEPARATOR . $type . \DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			return str_replace(\DIRECTORY_SEPARATOR, '/', $filePath);
		}
		return $name;
	}

	/**
	 * Get template path.
	 *
	 * @param string $templateName
	 * @param string $moduleName
	 *
	 * @return string
	 */
	public static function templatePath(string $templateName, string $moduleName = ''): string
	{
		return call_user_func_array([new Viewer(), 'getTemplatePath'], [$templateName, $moduleName]);
	}
}
