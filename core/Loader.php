<?php

/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

class Core_Loader {

	protected static $includeCache = [];

	static function import($name, $supressWarning = false) {

		if (isset(self::$includeCache[$name])) {
			return true;
		}

		if (!file_exists($name)) {
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

	public static function getModuleClassName($moduleName, $moduleType, $fieldName) {
		$filePath = $moduleName . DIRECTORY_SEPARATOR . $moduleType . DIRECTORY_SEPARATOR . $fieldName;
		$className = $moduleName . '_' . $moduleType . '_' . $fieldName;
		if (file_exists($filePath)) {
			return $className;
		}
var_dump($className);
		$filePath = 'Basic' . DIRECTORY_SEPARATOR . $moduleType . DIRECTORY_SEPARATOR . $fieldName;
		$className = 'Basic' . '_' . $moduleType . '_' . $fieldName;
		if (file_exists($filePath)) {
			return $className;
		}
var_dump($className);
		throw new PortalException('HANDLER_NOT_FOUND');
	}

	/**
	 * Function to auto load the required class files matching the directory pattern modules/xyz/types/Abc.php for class xyz_Abc_Type
	 * @param <String> $className
	 * @return <Boolean>
	 */
	public static function autoLoad($className) {
		$parts = explode('_', $className);
		$parts[0] = strtolower($parts[0]);
		$filePath = implode(DIRECTORY_SEPARATOR, $parts). '.php';

		if (file_exists($filePath)) {
			return self::import($filePath);
		}
		return false;
	}

}

class Config {
	public static function get($attr, $defvalue = '') {
		global $config;
		if(isset($config)){
			if(isset($config[$key])) {
				return $config[$key];
			}
		}
		return $defvalue;
	}
}

class PortalException extends Exception {	

}

spl_autoload_register('Core_Loader::autoLoad');
