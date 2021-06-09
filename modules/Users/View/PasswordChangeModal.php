<?php

/**
 * Password change modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Password change modal view class.
 */
class PasswordChangeModal extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public $successBtn = 'LBL_CHANGE_PASSWORD';

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('LBL_CHANGE_PASSWORD', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function getModalSize(): string
	{
		return 'modal-lg';
	}

	/** {@inheritdoc} */
	public function getModalIcon(): string
	{
		return 'yfi yfi-change-passowrd';
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$this->viewer->view('Modal/PasswordChangeModal.tpl', $this->request->getModule());
	}
}
