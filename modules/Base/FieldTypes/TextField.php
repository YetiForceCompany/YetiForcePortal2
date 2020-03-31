<?php
/**
 * Text field class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class TextField extends BaseField
{
	/**
	 * {@inheritDoc}
	 */
	public function getDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		return $this->value;
	}
}
