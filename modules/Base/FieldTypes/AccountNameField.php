<?php
/**
 * Account name field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Account name field class.
 */
class AccountNameField extends BaseField
{
	/**
	 * Function to get the view value.
	 *
	 * @return string
	 */
	public function getListDisplayValue(): string
	{
		$value = $this->value;
		if (empty($value)) {
			return '';
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			$value = '<span class="js-popover-tooltip" data-content="' . \App\Purifier::encodeHtml($value) . '">' . \App\TextParser::textTruncate($value, \App\Config::$listViewItemMaxLength) . '</span>';
		}
		return $value;
	}
}
