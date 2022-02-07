<?php
/**
 * Password change modal action file.
 *
 * @package Action
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

/**
 * Password change modal action class.
 */
class PasswordChangeModal extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/** {@inheritdoc} */
	public function process()
	{
		$response = new \App\Response();
		$changePassword = \App\Api::getInstance()->call('Users/ChangePassword', [
			'currentPassword' => $this->request->getRaw('oldPassword'),
			'newPassword' => $this->request->getRaw('password'),
		], 'put');
		if ($changePassword) {
			$response->setResult(\App\Language::translate('LBL_PASSWORD_CHANGED', 'Users'));
		} else {
			$response->setError(\App\Language::translate('LBL_FAILED_PASSWORD_CHANGED', 'Users'));
		}
		$response->emit();
	}
}
