<?php
/**
 * Shared owner UIType field file.
 *
 * @package UIType
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Shared owner UIType field class.
 */
class SharedOwnerField extends BaseField
{
	/** {@inheritdoc} */
	public function getTemplateName(): string
	{
		return 'Field/Edit/Owner.tpl';
	}
}
