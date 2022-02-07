<?php
/**
 * Tree UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Tree UIType field class.
 */
class TreeField extends BaseField
{
	/** {@inheritdoc} */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = [];
		if ($recordModel && false !== $recordModel->get($this->getName()) && '' !== $recordModel->get($this->getName())) {
			$value = [
				'value' => $recordModel->get($this->getName()),
				'raw' => $recordModel->getRawValue($this->getName()),
			];
		} elseif (empty($recordModel->getId()) && ($defaultEditValue = $this->get('defaultEditValue'))) {
			$value = $defaultEditValue;
		}
		return $value;
	}
}
