<?php
namespace Users\Action;

use Base\Action,
	Core;

/**
 * User Action Logout Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Logout extends Action\Base
{

	public function process(Core\Request $request)
	{
		$response = \Core\Api::getInstance()->call('Users/Logout', [], 'put');
		session_destroy();
		header('Location: ' . \Config::get('portalPath'));
	}
}
