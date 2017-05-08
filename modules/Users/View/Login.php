<?php
/**
 * Users view class
 * @package YetiForce.View
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Users\View;

use YF\Modules\Base\View,
	YF\Core;

class Login extends View\Index
{

	public function loginRequired()
	{
		return false;
	}

	public function checkPermission(\YF\Core\Request $request)
	{
		return true;
	}

	public function process(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('Login.tpl', $module);
	}
}
