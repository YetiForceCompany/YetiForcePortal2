<?php
/**
 * Shared owner field file.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

/**
 * Shared owner field class.
 */
class SharedOwnerField extends BaseField
{
	/** {@inheritdoc} */
	public function getTemplateName(): string
	{
		return 'Field/Edit/Owner.tpl';
	}
}
