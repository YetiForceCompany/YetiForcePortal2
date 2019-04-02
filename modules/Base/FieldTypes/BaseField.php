<?php
/**
 * Basic field model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

use App\Functions;
use App\Json;

class BaseField extends \App\BaseModel
{
	/**
	 * Display value.
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Raw value.
	 *
	 * @var string
	 */
	protected $rawValue;

	/**
	 * Is new record.
	 *
	 * @var string
	 */
	protected $isNewRecord = false;

	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function setIsNewRecord()
	{
		return $this->isNewRecord = true;
	}

	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function getDisplayValue()
	{
		return $this->value;
	}

	/**
	 * Function to set the view value.
	 *
	 * @param string $value
	 *
	 * @return Field
	 */
	public function setDisplayValue($value)
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * Function to set the name of the module to which the record belongs.
	 *
	 * @param string $value
	 *
	 * @return \self
	 */
	public function setModuleName($value)
	{
		$this->module = $value;
		return $this;
	}

	/**
	 * Field name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->get('name');
	}

	/**
	 * Function checks if there are permissions to preview record.
	 *
	 * @return bool
	 */
	public function isViewable()
	{
		return $this->get('isViewable');
	}

	/**
	 * Function checks if there are permissions to edit record.
	 *
	 * @return bool
	 */
	public function isEditable()
	{
		return $this->get('isEditable');
	}

	/**
	 * Function to check if the current field is mandatory or not.
	 *
	 * @return bool - true/false
	 */
	public function isMandatory()
	{
		return (bool) $this->get('mandatory');
	}

	/**
	 * Function to check if the current field is readonly or not.
	 *
	 * @return bool - true/false
	 */
	public function isEditableReadOnly()
	{
		return (bool) $this->get('isEditableReadOnly');
	}

	/**
	 * Field info.
	 *
	 * @param bool $safe
	 *
	 * @return array|string
	 */
	public function getFieldInfo($safe = false)
	{
		if ($safe) {
			return Purifier::encodeHtml(Json::encode($this->getData()));
		} else {
			return $this->getData();
		}
	}

	/**
	 * Reference module list.
	 *
	 * @return string
	 */
	public function getReferenceList()
	{
		return $this->get('referenceList');
	}

	/**
	 * Field parameters.
	 *
	 * @return string
	 */
	public function getFieldParams()
	{
		return $this->get('fieldparams');
	}

	/**
	 * Label.
	 *
	 * @return string
	 */
	public function getLabel()
	{
		return $this->get('label');
	}

	/**
	 * Picklist values.
	 *
	 * @return array
	 */
	public function getPicklistValues()
	{
		return $this->get('picklistvalues');
	}

	/**
	 * Function checks if there are permissions to edit record.
	 *
	 * @return bool
	 */
	public function getTemplate()
	{
		$type = ucfirst($this->get('type'));
		$module = $this->getModuleName();
		if (file_exists(YF_ROOT . '/layouts/Default/modules/' . $module . "/fieldtypes/$type.tpl")) {
			return "fieldtypes/$type.tpl";
		} elseif (file_exists(YF_ROOT . "/layouts/Default/modules/Base/fieldtypes/$type.tpl")) {
			return "fieldtypes/$type.tpl";
		} else {
			return 'fieldtypes/String.tpl';
		}
	}

	/**
	 * Function to get the name of the module to which the record belongs.
	 *
	 * @return string - Record Module Name
	 */
	public function getModuleName()
	{
		return $this->module;
	}

	/**
	 * Gets value to edit.
	 *
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function getEditViewDisplayValue()
	{
		return \App\Purifier::encodeHtml($this->getRawValue());
	}

	/**
	 * Function to get the raw value.
	 *
	 * @return Value for the given key
	 */
	public function getRawValue()
	{
		if (!$this->isNewRecord) {
			return $this->rawValue;
		} else {
			return $this->get('defaultvalue');
		}
	}

	/**
	 * Function to set the raw value.
	 *
	 * @param string $value
	 *
	 * @return Field
	 */
	public function setRawValue($value)
	{
		$this->rawValue = $value;
		return $this;
	}

	/**
	 * Validator.
	 *
	 * @return mixed
	 */
	public function getValidator()
	{
		return '';
	}

	/**
	 * Function which will check if empty piclist option should be given.
	 *
	 * @return bool
	 */
	public function isEmptyPicklistOptionAllowed()
	{
		return $this->get('isEmptyPicklistOptionAllowed');
	}
}
