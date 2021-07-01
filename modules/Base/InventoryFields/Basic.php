<?php
/**
 * Basic field model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\InventoryFields;

class Basic extends \App\BaseModel
{
	/**
	 * Sets name of module for field.
	 *
	 * @param string $moduleName
	 *
	 * @return self
	 */
	public function setModuleName(string $moduleName)
	{
		$this->set('moduleName', $moduleName);
		return $this;
	}

	/**
	 * Function to display data.
	 *
	 * @param string|null $value
	 *
	 * @return string
	 */
	public function getDisplayValue(?string $value): string
	{
		return \App\Purifier::encodeHtml((string) $value);
	}

	/**
	 * Returns label of field.
	 *
	 * @return string
	 */
	public function getLabel(): string
	{
		return \App\Purifier::encodeHtml($this->get('label'));
	}
}
