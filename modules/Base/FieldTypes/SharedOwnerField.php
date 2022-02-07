<?php
/**
 * Shared owner UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Shared owner UIType field class.
 */
class SharedOwnerField extends BaseField
{
	/** @var array Values list. */
	public $fieldValuesList;

	/**
	 * Get field values.
	 *
	 * @param \YF\Modules\Base\Model\Record|null $recordModel
	 *
	 * @return array
	 */
	public function getFieldValuesList(\YF\Modules\Base\Model\Record $recordModel = null): array
	{
		if (!\is_array($this->fieldValuesList)) {
			if ($recordModel && $recordModel->getId()) {
				$this->fieldValuesList = explode(',', $recordModel->getRawValue($this->getName()));
			} else {
				$this->fieldValuesList = [];
			}
		}
		return $this->fieldValuesList;
	}
}
