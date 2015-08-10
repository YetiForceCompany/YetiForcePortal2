<?php
/**
 * User Action Login Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Install\Action;

use Install\Model,
	Base\Action,
	Core;

class Install extends Action\Base
{

	public function loginRequired()
	{
		return false;
	}

	public function process(Core\Request $request)
	{
		$install = Model\Install::getInstance($request->getModule());
		$install->save($request);
	}
}
