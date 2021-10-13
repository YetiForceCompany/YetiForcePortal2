<?php
/**
 * Basic UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 * @author	  Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

use App\Json;

/**
 * Basic UIType field class.
 */
class BaseField extends \App\BaseModel
{
	/** @var int TabIndex last sequence number. */
	public static $tabIndexLastSeq = 0;

	/** @var int TabIndex default sequence number. */
	public static $tabIndexDefaultSeq = 0;

	/** @var string Default operator. */
	protected $defaultOperator = 'a';

	/** @var string[] Not supported field types. */
	protected $notSupportedToEdit = ['multiCurrency', 'serverAccess', 'multiReference', 'barcode', 'changesJson', 'iban', 'token', 'currencyInventory', 'twitter', 'multiReferenceValue', 'password', 'sharedOwner', 'taxes', 'recurrence', 'meetingUrl', 'reminder', 'totalTime',  'multiowner', 'userReference', 'currencyList', 'modules', 'inventoryLimit', 'multiEmail', 'multiDependField', 'smtp', 'multiDomain', 'magentoServer'];

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
		return $this->get('isEditable') && !\in_array($this->get('type'), $this->notSupportedToEdit);
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
			return \App\Purifier::encodeHtml(Json::encode($this->getData()));
		}
		return $this->getData();
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
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return array
	 */
	public function getPicklistValues(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$pickList = $this->get('picklistvalues');
		if ($recordModel && ($value = $recordModel->getRawValue($this->getName())) && !\in_array($value, array_keys($pickList))) {
			$pickList[$recordModel->getRawValue($this->getName())] = $recordModel->get($this->getName());
			$this->set('isEditableReadOnly', true);
		}
		return $pickList;
	}

	/**
	 * Gets template name.
	 *
	 * @return string
	 */
	public function getTemplateName(): string
	{
		$type = ucfirst($this->get('type'));
		return "Field/$type.tpl";
	}

	/**
	 * Gets template path.
	 *
	 * @param string $view
	 *
	 * @return string
	 */
	public function getTemplatePath(string $view): string
	{
		$name = $this->getTemplateName();
		$module = $this->getModuleName();
		if (file_exists(ROOT_DIRECTORY . "/layouts/Default/modules/{$module}/{$view}/{$name}") || file_exists(ROOT_DIRECTORY . "/layouts/Default/modules/Base/{$view}/{$name}")) {
			return "{$view}/{$name}";
		}
		return $view . '/Field/String.tpl';
	}

	/**
	 * Function to get the name of the module to which the record belongs.
	 *
	 * @return string - Record Module Name
	 */
	public function getModuleName(): string
	{
		return $this->module;
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

	/**
	 * Get TabIndex.
	 *
	 * @return int
	 */
	public function getTabIndex(): int
	{
		$tabindex = 0;
		if (0 !== $this->get('tabindex')) {
			$tabindex = $this->get('tabindex');
		} elseif (self::$tabIndexLastSeq) {
			$tabindex = self::$tabIndexLastSeq;
		}
		return $tabindex + self::$tabIndexDefaultSeq;
	}

	/**
	 * Get field label.
	 *
	 * @return string
	 */
	public function getFieldLabel(): string
	{
		return $this->get('label');
	}

	/**
	 * Get uitype.
	 *
	 * @return int
	 */
	public function getUIType(): int
	{
		return $this->get('uitype');
	}

	/**
	 * Gets header field value.
	 *
	 * @return array
	 */
	public function getHeaderValue(): array
	{
		return $this->get('header_field');
	}

	/**
	 * Gets operator.
	 *
	 * @return string
	 */
	public function getOperator(): string
	{
		$operator = $this->defaultOperator;
		if (\in_array($this->get('type'), ['modules', 'time', 'userCreator', 'owner', 'picklist', 'tree', 'boolean', 'fileLocationType', 'userRole', 'multiReferenceValue', 'inventoryLimit'])) {
			$operator = 'e';
		}
		return $operator;
	}

	/**
	 * Gets value to edit.
	 *
	 * @param mixed                              $value
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return mixed
	 */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = '';
		if ($recordModel && false !== $recordModel->get($this->getName())) {
			$value = $recordModel->getRawValue($this->getName());
		} elseif (empty($recordModel->getId())) {
			$value = $this->get('defaultvalue') ?: '';
		}
		return \App\Purifier::encodeHtml($value);
	}

	/**
	 * Function to get the view value.
	 *
	 * @param mixed                              $value
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return string
	 */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		return $value ? \App\Purifier::encodeHtml($value) : '';
	}

	/**
	 * Function to get the list view value.
	 *
	 * @param mixed                              $value
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return string
	 */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		return $this->getDisplayValue($value, $recordModel);
	}

	/**
	 * Set data to api container.
	 *
	 * @param \App\Request $request
	 * @param \App\Api     $api
	 *
	 * @return $this
	 */
	public function setApiData(\App\Request $request, \App\Api $api)
	{
		if ($request->has($this->getName())) {
			$api->setDataBody([$this->getName() => $request->getRaw($this->getName())]);
		}
		return $this;
	}
}
