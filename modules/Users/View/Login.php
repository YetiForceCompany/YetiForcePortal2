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
	/**
	 * {@inheritdoc}
	 */
	public function loginRequired()
	{
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function checkPermission()
	{
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$module = $this->request->getModule();
		$viewer = $this->getViewer($this->request);
		$viewer->view('Login.tpl', $module);
	}
}
