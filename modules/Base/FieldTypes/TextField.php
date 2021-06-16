<?php
/**
 * Text field class.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class TextField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		return $this->value;
	}

	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function getListDisplayValue(): string
	{
		$value = $this->getDisplayValue();
		if (empty($value)) {
			return '';
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			$value = \App\Viewer::truncateText($value, \App\Config::$listViewItemMaxLength, true);
		}
		return $value;
	}
}
