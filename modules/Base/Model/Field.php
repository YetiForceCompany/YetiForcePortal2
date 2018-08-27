<?php
/**
 * Basic field model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Loader;

class Field extends \App\BaseModel
{
	/**
	 * Static Function to get the instance of a clean Record for the given module name.
	 *
	 * @param string $module
	 * @param []     $field
	 *
	 * @return \self
	 */
	public static function getInstance($module, $field)
	{
		$type = ucfirst($field['type']);
		if (file_exists(YF_ROOT . '/modules/Base/FieldTypes/' . $type . 'Field.php')) {
			$handlerModule = Loader::getModuleClassName($module, 'FieldTypes', $type . 'Field');
		} else {
			$handlerModule = Loader::getModuleClassName($module, 'FieldTypes', 'BaseField');
		}

		$instance = new $handlerModule();
		return $instance->setModuleName($module)->setData($field);
	}
}
