<?php
/**
 * Documents file upload UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Documents file upload UIType field class.
 */
class DocumentsFileUploadField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\is_array($value)) {
			$value = $value['name'];
		}
		return $value;
	}

	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\is_array($value)) {
			$value = $value['name'];
		}
		return $value;
	}
}
