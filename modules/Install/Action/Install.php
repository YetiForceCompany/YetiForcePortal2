<?php
/**
 * User action login class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Install\Action;

use Install\Model,
	YF\Modules\Base\Action,
	YF\Core;

class Install extends Action\Base
{

	public function loginRequired()
	{
		return false;
	}

	public function process(\YF\Core\Request $request)
	{
		$install = Model\Install::getInstance($request->getModule());
		$install->save($request);
	}
}
