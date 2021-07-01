<?php
/**
 * Date time UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Date time UIType field class.
 */
class DateTimeField extends DateField
{
	/** @var string Default operator. */
	protected $defaultOperator = 'bw';

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
