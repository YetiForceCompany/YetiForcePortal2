<?php
/**
 * Multipicklist UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Multipicklist UIType field class.
 */
class MultipicklistField extends BaseField
{
	/**
	 * values list.
	 *
	 * @var array
	 */
	public $fieldValuesList;

	/**
	 * not display values list.
	 *
	 * @var array
	 */
	public $notDisplayValuesList;

	/**
	 * Get not display values list.
	 *
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return array
	 */
	public function getNotDisplayValuesList(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		if (!\is_array($this->notDisplayValuesList)) {
			if ($recordModel && $recordModel->getId()) {
				$this->notDisplayValuesList = array_diff_key(array_flip($this->getFieldValuesList($recordModel)), $this->getPicklistValues($recordModel));
			} else {
				$this->notDisplayValuesList = [];
			}
		}
		return $this->notDisplayValuesList;
	}

	/**
	 * Get field values.
	 *
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return array
	 */
	public function getFieldValuesList(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		if (!\is_array($this->fieldValuesList)) {
			if ($recordModel && $recordModel->getId()) {
				$this->fieldValuesList = explode(' |##| ', $recordModel->getRawValue($this->getName()));
			} else {
				$this->fieldValuesList = [];
			}
		}
		return $this->fieldValuesList;
	}
}
