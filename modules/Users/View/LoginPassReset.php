<?php
/**
 * Users login view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Users login view class.
 */
class LoginPassReset extends Login
{
	/** {@inheritdoc} */
	public function getPageTitle(): string
	{
		return \App\Language::translate('LBL_LOGIN_PAGE', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function process()
	{
		$module = $this->request->getModule();
		if (isset($_SESSION['reset_errors'])) {
			$this->viewer->assign('ERRORS', $_SESSION['reset_errors'] ?? []);
			unset($_SESSION['reset_errors']);
		}
		if ($this->request->isEmpty('mode')) {
			$this->viewer->view('LoginPassReset.tpl', $module);
		} else {
			if ('token' !== $this->request->getByType('mode', \App\Purifier::ALNUM)) {
				throw new \App\Exceptions\NoPermitted('Invalid mode');
			}
			if (!$this->request->isEmpty('token')) {
				$this->viewer->assign('TOKEN', $this->request->getByType('token', \App\Purifier::ALNUM));
			}
			$this->viewer->view('LoginPassResetToken.tpl', $module);
		}
	}
}
