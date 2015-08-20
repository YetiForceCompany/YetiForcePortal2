<?php
/**
 * User Action Logout Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Users\Action;

use Base\Action,
	Core;

class Logout extends Action\Base
{

	public function process(Core\Request $request)
	{
		$userInstance = Core\User::getUser();
		$userInstance->logout();

		header('Location: /');
	}
}
