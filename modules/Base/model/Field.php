<?php
/**
 * Basic Field Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\Model;

use Core;

class Field extends \Core\BaseModel
{

	/**
	 * Function to set the name of the module to which the record belongs
	 * @param string $value
	 * @return \self
	 */
	public function setModuleName($value)
	{
		$this->module = $value;
		return $this;
	}

	/**
	 * Function to get the name of the module to which the record belongs
	 * @return string - Record Module Name
	 */
	public function getModuleName()
	{
		return $this->module;
	}

	/**
	 * Field name
	 * @return string
	 */
	public function getName()
	{
		return $this->get('name');
	}

	/**
	 * Static Function to get the instance of a clean Record for the given module name
	 * @param type $module
	 * @return \self
	 */
	public static function getInstance($module)
	{
		$handlerModule = Core\Loader::getModuleClassName($module, 'Model', 'Field');
		$instance = new $handlerModule();
		return $instance->setModuleName($module);
	}

	/**
	 * Function checks if there are permissions to preview record
	 * @return boolean
	 */
	public function isViewable()
	{
		return $this->get('isViewable');
	}

	/**
	 * Function checks if there are permissions to edit record
	 * @return boolean
	 */
	public function isEditable()
	{
		return $this->get('isEditable');
	}

	/**
	 * Function to check if the current field is mandatory or not
	 * @return boolean - true/false
	 */
	public function isMandatory()
	{
		return (bool) $this->get('mandatory');
	}

	/**
	 * Function to check if the current field is readonly or not
	 * @return boolean - true/false
	 */
	public function isEditableReadOnly()
	{
		return (bool) $this->get('isEditableReadOnly');
	}

	/**
	 * Field info
	 * @return array
	 */
	public function getFieldInfo()
	{
		return $this->getData();
	}

	/**
	 * Reference module list
	 * @return string[]
	 */
	public function getReferenceList()
	{
		return $this->get('referenceList');
	}

	/**
	 * Picklist values
	 * @return array
	 */
	public function getPicklistValues()
	{
		return $this->get('picklistvalues');
	}

	/**
	 * Function checks if there are permissions to edit record
	 * @return boolean
	 */
	public function getTemplate()
	{
		$type = ucfirst($this->get('type'));
		if (!in_array($type, ['Reference', 'ReferenceProcess', 'ReferenceSubProcess', 'ReferenceLink', 'Picklist', 'Owner', 'Boolean', 'Text', 'Url', 'SharedOwner', 'Multipicklist', 'Email', 'Percentage', 'Phone', 'Date', 'Time', 'Integer', 'Decimal'])) {
			$type = 'String';
		}
		return "fieldtypes/$type.tpl";
	}

	/**
	 * Gets value to edit
	 * @param mixed $value
	 * @return mixed
	 */
	public function getEditViewDisplayValue($value)
	{
		return $value;
	}

	/**
	 * Validator
	 * @return mixed
	 */
	public function getValidator()
	{
		return '';
	}

	/**
	 * Function which will check if empty piclist option should be given
	 * @return boolean
	 */
	public function isEmptyPicklistOptionAllowed()
	{
		if ($this->isMandatory()) {
			return false;
		}
		return true;
	}
}
