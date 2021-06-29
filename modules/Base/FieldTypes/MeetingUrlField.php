<?php
/**
 * Reference sub process second level UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Reference sub process second level UIType field class.
 */
class MeetingUrlField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		$rawValue = \App\TextParser::textTruncate($value, \App\Config::$listViewItemMaxLength);
		return '<a class="urlField u-cursor-pointer" title="' . $value . '" href="' . $value . '" target="_blank" rel="noreferrer noopener">' . \App\Purifier::encodeHtml($rawValue) . '</a>';
	}
}
