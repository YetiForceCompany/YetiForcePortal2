<?php
/**
 * Boolean UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Michał Lorencik <m.lorencik@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Boolean UIType field class.
 */
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
