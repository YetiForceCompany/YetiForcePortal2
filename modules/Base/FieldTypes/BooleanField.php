<?php
/**
 * Boolean Field Class
 * @package YetiForce.Field
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
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
		if ($rawValue === true || (int) $rawValue === 1 || $rawValue === 'yes') {
			return true;
		}
		return false;
	}
}
