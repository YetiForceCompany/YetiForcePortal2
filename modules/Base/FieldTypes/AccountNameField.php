<?php
/**
 * Text field class.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class AccountNameField extends BaseField
{
	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function getListDisplayValue(): string
	{
		$value = $this->getDisplayValue();
		if (\strlen($value) > \App\Config::$lengthFildList) {
			$value = '<span class="js-popover-tooltip" data-content="' . $value . '">' . \App\TextParser::textTruncate($this->getDisplayValue(), \App\Config::$lengthFildList) . '</span>';
		}
		return $value;
	}
}
