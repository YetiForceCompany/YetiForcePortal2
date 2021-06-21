<?php
/**
 * Account name field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Account name field class.
 */
class AccountNameField extends BaseField
{
	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			$value = '<span class="js-popover-tooltip" data-content="' . \App\Purifier::encodeHtml($value) . '">' . \App\TextParser::textTruncate($value, \App\Config::$listViewItemMaxLength) . '</span>';
		}
		return $value;
	}
}
