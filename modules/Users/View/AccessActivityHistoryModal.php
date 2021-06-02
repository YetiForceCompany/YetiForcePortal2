<?php

/**
 * Access activity history modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Access activity history modal view class.
 */
class AccessActivityHistoryModal extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('BTN_YOUR_ACCOUNT_ACCESS_HISTORY', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function getModalSize(): string
	{
		return 'modal-full';
	}

	/** {@inheritdoc} */
	public function getModalIcon(): string
	{
		return 'yfi yfi-login-history';
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$this->viewer->view('Modal/AccessActivityHistoryModal.tpl', $this->request->getModule());
	}
}
