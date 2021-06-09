<?php
/**
 * Two factor authentication modal action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

/**
 * Two factor authentication modal action class.
 */
class TwoFactorAuthenticationModal extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$user = \App\User::getUser();
		if ('PLL_PASSWORD_2FA' !== $user->get('login_method') || $user->isEmpty('authy_methods')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$response = new \App\Response();
		if ($this->request->isEmpty('secret')) {
			\App\Api::getInstance()->call('Users/TwoFactorAuth', [], 'delete');
			$response->setResult(\App\Language::translate('LBL_2FA_HAS_BEEN_DISABLED', 'Users'));
		} else {
			try {
				$api = \App\Api::getInstance()->call('Users/TwoFactorAuth', [
					'methods' => $this->request->getByType('method', \App\Purifier::STANDARD),
					'code' => $this->request->getByType('code', \App\Purifier::ALNUM),
					'secret' => $this->request->getByType('secret', \App\Purifier::ALNUM),
				], 'post');
				if ('Ok' === $api) {
					$response->setResult(\App\Language::translate('LBL_2FA_HAS_BEEN_ACTIVATED', 'Users'));
				} else {
					$response->setError($api);
				}
			} catch (\Throwable $th) {
				$response->setError($th->getMessage());
			}
		}
		$response->emit();
	}
}
