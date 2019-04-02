<?php
/**
 * System files loader.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class Loader
{
	protected static $includeCache = [];

	public static function import($name, $supressWarning = false): bool
	{
		if (isset(self::$includeCache[$name])) {
			return true;
		}
		if (!file_exists($name)) {
			throw new AppException('FILE_NOT_FOUND: ' . $name);
		}
		$status = -1;
		if ($supressWarning) {
			$status = @include_once $name;
		} else {
			$status = include_once $name;
		}
		$success = (0 === $status) ? false : true;
		if ($success) {
			self::$includeCache[$name] = $name;
		}
		return $success;
	}

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
		$filePath = YF_ROOT . \DIRECTORY_SEPARATOR . 'modules' . \DIRECTORY_SEPARATOR . $moduleName . \DIRECTORY_SEPARATOR . $moduleType . \DIRECTORY_SEPARATOR . $fieldName . '.php';
		if (file_exists($filePath)) {
			return '\\YF\\Modules' . '\\' . $moduleName . '\\' . $moduleType . '\\' . $fieldName;
		}
		$filePath = YF_ROOT . \DIRECTORY_SEPARATOR . 'modules' . \DIRECTORY_SEPARATOR . 'Base' . \DIRECTORY_SEPARATOR . $moduleType . \DIRECTORY_SEPARATOR . $fieldName . '.php';
		if (file_exists($filePath)) {
			return '\\YF\\Modules\\Base' . '\\' . $moduleType . '\\' . $fieldName;
		}
		throw new AppException("HANDLER_NOT_FOUND: $moduleName, $moduleType, $fieldName");
	}
}
