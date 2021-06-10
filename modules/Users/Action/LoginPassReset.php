<?php
/**
 * User action login file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

use App\Config;

/**
 * User action login class.
 */
class LoginPassReset extends Login
{
	/** @var string Return URL */
	private $url;

	/** {@inheritdoc} */
	public function process()
	{
		$this->url = Config::$portalUrl . 'index.php?module=Users';
		$this->checkBruteForce();
		try {
			if ($this->request->isEmpty('mode')) {
				$this->url .= '&view=LoginPassReset';
				if ($this->request->isEmpty('email')) {
					throw new \App\Exceptions\NoPermitted('No e-mail address');
				}
				$this->sendToken();
			} else {
				$this->url .= '&view=Login';
				if ('token' !== $this->request->getByType('mode', \App\Purifier::ALNUM)) {
					throw new \App\Exceptions\NoPermitted('Invalid mode');
				}
				$this->changePassword();
			}
		} catch (\Throwable $th) {
			if ($this->request->isEmpty('mode')) {
				$_SESSION['reset_errors'][] = $th->getMessage();
			} else {
				$_SESSION['login_errors'][] = $th->getMessage();
			}
		}
		header('Location: ' . $this->url);
	}

	/**
	 * Send token by API.
	 *
	 * @return void
	 */
	public function sendToken(): void
	{
		$response = \App\Api::getInstance()->call('Users/ResetPassword', [
			'userName' => $this->request->getByType('email', \App\Purifier::TEXT),
			'deviceId' => $this->request->getByType('fingerprint', \App\Purifier::ALNUM_EXTENDED),
		], 'post');
		if ($response['mailerStatus']) {
			$_SESSION['reset_errors'][] = \App\Language::translateArgs('LBL_RESET_PASSWORD_LINK_SENT', 'Users', $response['expirationDate']);
			$this->url .= '&mode=token';
		} else {
			$_SESSION['reset_errors'][] = \App\Language::translate('LBL_RESET_PASSWORD_SMTP_ERROR', 'Users');
		}
	}

	/**
	 * Change password by API.
	 *
	 * @return void
	 */
	public function changePassword(): void
	{
		$response = \App\Api::getInstance()->call('Users/ResetPassword', [
			'token' => $this->request->getByType('token', \App\Purifier::ALNUM),
			'password' => $this->request->getRaw('password'),
			'deviceId' => $this->request->getByType('fingerprint', \App\Purifier::ALNUM_EXTENDED),
		], 'put');
		if ($response) {
			$_SESSION['login_errors'][] = \App\Language::translate('LBL_PASSWORD_CHANGED', 'Users');
		} else {
			$_SESSION['login_errors'][] = \App\Language::translate('LBL_FAILED_PASSWORD_CHANGED', 'Users');
		}
	}
}
