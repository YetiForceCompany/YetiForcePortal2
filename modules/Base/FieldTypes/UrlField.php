<?php
/**
 * Url UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Url UIType field class.
 */
class UrlField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		if (empty($value)) {
			return '';
		}
		$value = \App\Purifier::encodeHtml($value);
		return '<a class="u-cursor-pointer" title="' . $value . '" href="' . $value . '" target="_blank" rel="noreferrer noopener">' . $value . '</a>';
	}
}
