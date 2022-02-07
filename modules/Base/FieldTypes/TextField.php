<?php
/**
 * Text field class.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class TextField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		return $value ?: '';
	}

	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		$value = $this->getDisplayValue($value, $recordModel);
		if (empty($value)) {
			return '';
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			$value = \App\Viewer::truncateText($value, \App\Config::$listViewItemMaxLength, true);
		}
		return $value;
	}
}
