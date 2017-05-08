<?php
/**
 * User Action Login Class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Users\Action;

use YF\Modules\Base\Action,
	YF\Core;

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

	public function process(\YF\Core\Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');
		$userInstance = \YF\Core\User::getUser();
		$userInstance->set('language', $request->get('language'));
		$userInstance->login($email, $password);

		header('Location: ' . \YF\Core\Config::get('portalPath'));
	}
}
