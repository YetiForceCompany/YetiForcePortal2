<?php
/**
 * Multipicklist UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
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
	 * @return array
	 */
	public function getNotDisplayValuesList()
	{
		if (!\is_array($this->notDisplayValuesList)) {
			if (!$this->isNewRecord) {
				$this->notDisplayValuesList = array_diff_key(array_flip($this->getFieldValuesList()), $this->getPicklistValues());
			} else {
				$this->notDisplayValuesList = [];
			}
		}
		return $this->notDisplayValuesList;
	}

	/**
	 * Get field values.
	 *
	 * @return array
	 */
	public function getFieldValuesList()
	{
		if (!\is_array($this->fieldValuesList)) {
			if (!$this->isNewRecord) {
				$this->fieldValuesList = explode(' |##| ', $this->rawValue);
			} else {
				$this->fieldValuesList = [];
			}
		}
		return $this->fieldValuesList;
	}
}
