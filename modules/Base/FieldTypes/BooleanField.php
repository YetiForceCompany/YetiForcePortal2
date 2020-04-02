<?php
/**
 * Boolean field class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class BooleanField extends BaseField
{
	/**
	 * Check field is checked.
	 *
	 * @return bool
	 */
	public function isChecked()
	{
		return 1 === (int) $this->getRawValue();
	}
}
