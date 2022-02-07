<?php
/**
 * Email UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Email UIType field class.
 */
class EmailField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		$value = \App\Purifier::encodeHtml($value);
		return "<a class=\"u-cursor-pointer\" href=\"mailto:{$value}\">{$value}</a>";
	}

	/** {@inheritdoc} */
	public function getListDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		if (\mb_strlen($value) > \App\Config::$listViewItemMaxLength) {
			return '<a class="u-cursor-pointer js-popover-tooltip" data-content="' . \App\Purifier::encodeHtml($value) . '" href="mailto:' . \App\Purifier::encodeHtml($value) . '">' . \App\TextParser::textTruncate($value, \App\Config::$listViewItemMaxLength) . '</a>';
		}
		return $this->getDisplayValue($value, $recordModel);
	}
}
