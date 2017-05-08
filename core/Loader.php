<?php
/**
 * System files loader
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @package YetiForce.Core
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Core;

class Loader
{

	protected static $includeCache = [];

	static function import($name, $supressWarning = false)
	{

		if (isset(self::$includeCache[$name])) {
			return true;
		}

		if (!file_exists($name)) {
			throw new AppException('FILE_NOT_FOUND: ' . $name);
			return false;
		}

		$status = -1;
		if ($supressWarning) {
			$status = @include_once $name;
		} else {
			$status = include_once $name;
		}

		$success = ($status === 0) ? false : true;

		if ($success) {
			self::$includeCache[$name] = $name;
		}

		return $success;
	}

	public static function getModuleClassName($moduleName, $moduleType, $fieldName)
	{
		$filePath = YF_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $moduleType . DIRECTORY_SEPARATOR . $fieldName . '.php';
		$className = '\\YF\\Modules' . '\\' . $moduleName . '\\' . $moduleType . '\\' . $fieldName;
		//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		if (file_exists($filePath)) {
			return $className;
		}

		$filePath = YF_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Base' . DIRECTORY_SEPARATOR . $moduleType . DIRECTORY_SEPARATOR . $fieldName . '.php';
		$className = '\\YF\\Modules\\Base' . '\\' . $moduleType . '\\' . $fieldName;
		if (file_exists($filePath)) {
			return $className;
		}

		throw new AppException("HANDLER_NOT_FOUND: $moduleName, $moduleType, $fieldName");
	}
}
