<?php
/**
 * Boolean field class
 * @package YetiForce.Field
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
namespace YF\Modules\Base\FieldTypes;

class BooleanField extends BaseField
{

	/**
	 * Check field is checked
	 * @return boolean
	 */
	public function isChecked()
	{
		$rawValue = $this->getRawValue();
		if ((int) $rawValue === 1) {
			return true;
		}
		return false;
	}
}
