<?php
/**
 * Email UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Email UIType field class.
 */
class EmailField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		$value = \App\Purifier::encodeHtml($this->value);
		return "<a class=\"u-cursor-pointer\" href=\"mailto:{$value}\">{$value}</a>";
	}

	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	 public function getListDisplayValue(): string
	 {
		 return  $this->getDisplayValue();
	 }
}
