<?php
/**
 * User Action Login Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Install\Action;

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
