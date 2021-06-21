<?php
/**
 * Image UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Image UIType field class.
 */
class MultiImageField extends BaseField
{
	/** {@inheritdoc} */
	public function isEditable()
	{
		return false;
	}

	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		$values = '';
		$data = \is_array($value) ? $value : [$value];
		foreach ($data as $value) {
			$values .= "<div style=\"width:80px\" class=\"ml-1\"><img src=\"data:image/jpeg;base64,{$value}\"/></div>";
		}
		return $values;
	}
}
