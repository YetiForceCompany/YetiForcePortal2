<?php
/**
 * Delete Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
namespace YF\Modules\Base\FieldTypes;

class StringField extends \YF\Modules\Base\Model\Field
{

	public function getRawValue()
	{
		return "wygląda pro";
	}

	public function getViewValue()
	{
		return "wygląda pro";
	}
}
