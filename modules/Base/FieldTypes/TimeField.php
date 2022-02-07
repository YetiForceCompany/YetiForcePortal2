<?php
/**
 * Time UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Time UIType field class.
 */
class TimeField extends BaseField
{
	/** {@inheritdoc} */
	public function getEditViewDisplayValue(\YF\Modules\Base\Model\Record $recordModel = null)
	{
		$value = '';
		if ($recordModel && '' !== $recordModel->get($this->getName())) {
			$value = $recordModel->getDisplayValue($this->getName());
		} elseif (empty($recordModel->getId())) {
			$value = $this->get('defaultvalue') ?: '';
		}
		return \App\Purifier::encodeHtml($value);
	}
}
