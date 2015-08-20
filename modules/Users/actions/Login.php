<?php
/**
 * User Action Login Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Users\Action;

use Base\Action,
	Core;

class Login extends Action\Base
{

	public function checkPermission()
	{
		return true;
	}

	public function loginRequired()
	{
		return false;
	}

	public function process(Core\Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');
		$userInstance = Core\User::getUser();
		$userInstance->set('language', $request->get('language'));
		$userInstance->login($email, $password);

		header('Location: /');
	}
}
