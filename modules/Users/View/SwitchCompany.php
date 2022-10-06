<?php

/**
 * Switch company modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Switch company modal view class.
 */
class SwitchCompany extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public $successBtn = 'LBL_CHANGE';

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$user = \App\User::getUser();
		if (!$user->getCompanies()) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('LBL_SWITCH_USERS', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function getModalSize(): string
	{
		return 'modal-md';
	}

	/** {@inheritdoc} */
	public function getModalIcon(): string
	{
		return 'fas fa-exchange-alt';
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$user = \App\User::getUser();

		$this->viewer->assign('COMPANIES', $user->getCompanies());
		$this->viewer->view('Modal/SwitchCompany.tpl', $this->request->getModule());
	}
}
