<?php
/**
 * Taxes UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Taxes UIType field class.
 */
class TaxesField extends BaseField
{
	/** {@inheritdoc} */
	public function getDisplayValue($value, \YF\Modules\Base\Model\Record $recordModel = null): string
	{
		return empty($value['value']) ? '' : \App\Purifier::encodeHtml($value['value']);
	}
}
