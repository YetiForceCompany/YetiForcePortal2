<?php
/**
 * Users view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Users\View;

use Base\View,
	Core;

class Login extends View\Index
{

	public function loginRequired()
	{
		return false;
	}

	public function checkPermission(Core\Request $request)
	{
		return true;
	}

	public function process(Core\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		if (isset($_SESSION['loginError'])) {
			$viewer->assign('LOGIN_ERROR', $_SESSION['loginError']);
			unset($_SESSION['loginError']);
		}
		$viewer->view('Login.tpl', $module);
	}
}
