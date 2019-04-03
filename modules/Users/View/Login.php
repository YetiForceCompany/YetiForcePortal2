<?php
/**
 * Users view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\View;

class Login extends \App\Controller\View
{
	public function loginRequired()
	{
		return false;
	}

	public function checkPermission(\App\Request $request)
	{
		return true;
	}

	public function process(\App\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('Login.tpl', $module);
	}
}
