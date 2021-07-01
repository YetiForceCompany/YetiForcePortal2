<?php
/**
 * System files loader.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class Loader
{
	protected static $includeCache = [];

	/**
	 * Get the class name for the module.
	 *
	 * @param string $moduleName
	 * @param string $moduleType
	 * @param string $fieldName
	 *
	 * @return string
	 */
	public static function getModuleClassName(string $moduleName, string $moduleType, string $fieldName): string
	{
		$filePath = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'modules' . \DIRECTORY_SEPARATOR . $moduleName . \DIRECTORY_SEPARATOR . $moduleType . \DIRECTORY_SEPARATOR . $fieldName . '.php';
		if (file_exists($filePath)) {
			return '\\YF\\Modules' . '\\' . $moduleName . '\\' . $moduleType . '\\' . $fieldName;
		}
		$filePath = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . 'modules' . \DIRECTORY_SEPARATOR . 'Base' . \DIRECTORY_SEPARATOR . $moduleType . \DIRECTORY_SEPARATOR . $fieldName . '.php';
		if (file_exists($filePath)) {
			return '\\YF\\Modules\\Base' . '\\' . $moduleType . '\\' . $fieldName;
		}
		throw new Exceptions\AppException("HANDLER_NOT_FOUND: $moduleName, $moduleType, $fieldName");
	}
}
