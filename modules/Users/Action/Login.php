<?php
/**
 * User action login class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

class Login extends \App\Controller\Action
{
	public function checkPermission(\App\Request $request)
	{
		return true;
	}

	public function loginRequired()
	{
		return false;
	}

	public function process(\App\Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');
		$userInstance = \App\User::getUser();
		$userInstance->set('language', $request->get('language'));
		$userInstance->login($email, $password);

		header('Location: ' . \App\Config::$portalUrl);
	}
}
