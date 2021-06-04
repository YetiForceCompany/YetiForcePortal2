<?php
/**
 * Basic field model class.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Loader;

class InventoryField extends \App\BaseModel
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
		if (file_exists(ROOT_DIRECTORY . '/modules/Base/InventoryFields/' . $type . 'Field.php')) {
			$handlerModule = Loader::getModuleClassName($module, 'InventoryFields', $type . 'Field');
		} else {
			$handlerModule = Loader::getModuleClassName($module, 'InventoryFields', 'Basic');
		}

		$instance = new $handlerModule();
		return $instance->setModuleName($module)->setData($field);
	}
}
