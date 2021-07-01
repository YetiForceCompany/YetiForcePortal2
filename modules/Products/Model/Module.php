<?php
/**
 * Products module model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

class Module extends \YF\Modules\Base\Model\Module
{
	/** {@inheritdoc} */
	public function getDefaultView(): string
	{
		return \Conf\Modules\Products::$shoppingMode ? 'Tree' : parent::getDefaultView();
	}
}
