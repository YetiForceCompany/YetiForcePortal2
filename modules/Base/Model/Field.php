<?php
/**
 * Basic Field Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
namespace YF\Modules\Base\Model;

use \YF\Core\Loader;

class Field extends \YF\Core\BaseModel
{

	/**
	 * Static Function to get the instance of a clean Record for the given module name
	 * @param string $module
	 * @param [] $field
	 * @return \self
	 */
	public static function getInstance($module, $field)
	{
		$type = ucfirst($field['type']);
		if (file_exists(YF_ROOT . "/modules/Base/FieldTypes/" . $type . "Field.php")) {
			$handlerModule = Loader::getModuleClassName($module, 'FieldTypes', $type . 'Field');
		} else {
			$handlerModule = Loader::getModuleClassName($module, 'FieldTypes', 'BaseField');
		}

		$instance = new $handlerModule();
		return $instance->setModuleName($module)->setData($field);
	}
}
