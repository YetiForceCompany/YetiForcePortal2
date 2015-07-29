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

	public function loginRequired()
	{
		return false;
	}

	public function process(Core\Request $request)
	{
		$_SESSION['language'] = $request->get('language');
		$email = $request->get('email');
		$password = $request->get('password');
		$userInstance = Core\User::getUser();
		$response = $userInstance->doLogin($email, $password);
		if (isset($response['errorExists'])) {
			$_SESSION['loginError'] = $response['massage'];
		}
		header('Location: /');
	}
}
