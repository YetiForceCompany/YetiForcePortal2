<?php
/**
 * Image field class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\FieldTypes;

class MultiImageField extends BaseField
{
	/**
	 * {@inheritDoc}
	 */
	public function isEditable()
	{
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayValue(): string
	{
		if (empty($this->value)) {
			return '';
		}
		$values = '';
		$data = \is_array($this->value) ? $this->value : [$this->value];
		foreach($data as $value){
			$values .= "<div style=\"width:80px\" class=\"ml-1\"><img src=\"data:image/jpeg;base64,{$value}\"/></div>";
		}
		return $values;
	}
}
