<?php
/**
 * A class that facilitates the use of resources.
 *
 * @package   App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
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
		$fileURL = 'layouts/' . Viewer::getLayoutName() . "/modules/$moduleName/$type/$name";
		$filePath = ROOT_DIRECTORY . '/public_html/' . $fileURL;
		if (file_exists($filePath)) {
			return PUBLIC_DIRECTORY . $fileURL;
		}
		$fileURL = 'layouts/' . Viewer::getLayoutName() . "/skins/$type/$name";
		$filePath = ROOT_DIRECTORY . '/public_html/' . $fileURL;
		if (file_exists($filePath)) {
			return PUBLIC_DIRECTORY . $fileURL;
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
		return \call_user_func_array([new Viewer(), 'getTemplatePath'], [$templateName, $moduleName]);
	}
}
