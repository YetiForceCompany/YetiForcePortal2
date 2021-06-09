<?php

/**
 * Two factor authentication modal view file.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\View;

/**
 * Two factor authentication modal view class.
 */
class TwoFactorAuthenticationModal extends \App\Controller\Modal
{
	/** @var string Secret key */
	protected $secretKey = '';

	/** @var string Auth methods */
	protected $authMethods;

	/** {@inheritdoc} */
	protected function getModalSize()
	{
		return 'modal-lg';
	}

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$user = \App\User::getUser();
		if ('PLL_PASSWORD_2FA' !== $user->get('login_method') || $user->isEmpty('authy_methods')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
		if ($user->get('2faObligatory') && 'PLL_AUTHY_TOTP' === $user->get('authy_methods')) {
			$this->lockExit = true;
		}
	}

	/**  {@inheritdoc}  */
	public function getTitle(): string
	{
		return \App\Language::translate('BTN_2FA_TOTP_QR_CODE', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function getModalIcon(): string
	{
		return 'fas fa-key';
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$response = \App\Api::getInstance()->call('Users/TwoFactorAuth');
		if (empty($response['secretKey'])) {
			$this->authMethods = $response['authMethods'];
		} else {
			['authMethods' => $this->authMethods , 'secretKey' => $this->secretKey] = $response;
			$this->viewer->assign('QR_CODE_HTML', $this->createQrCodeForUser());
		}
		$this->viewer->assign('SECRET_KEY', $this->secretKey);
		$this->viewer->assign('AUTH_METHODS', $this->authMethods);
		$this->viewer->view('Modal/TwoFactorAuthenticationModal.tpl', $this->request->getModule());
	}

	/**
	 * Generate otaauth url for QR codes.
	 *
	 * @see https://github.com/google/google-authenticator/wiki/Key-Uri-Format
	 *
	 * @param string      $secret - REQUIRED: The secret parameter is an arbitrary key value encoded in Base32 according to RFC 3548. The padding specified in RFC 3548 section 2.2 is not required and should be omitted.
	 * @param string      $name   - The name is used to identify which account a key is associated with.
	 * @param string|null $issuer - STRONGLY RECOMMENDED: The issuer parameter is a string value indicating the provider or service this account is associated with, URL-encoded according to RFC 3986.
	 *
	 * @return string - otpauth url
	 */
	public function getOtpAuthUrl($secret, $name, $issuer = null): string
	{
		if (null === $issuer) {
			$arr = parse_url(\App\Config::$portalUrl);
			$issuer = $arr['host'] ?? '';
		}
		$url = "otpauth://totp/{$issuer}:{$name}?secret={$secret}";
		if (!empty($issuer)) {
			$url .= "&issuer={$issuer}";
		}
		return $url;
	}

	/**
	 * Create QR code for user.
	 *
	 * @param string $type - acceptable types [HTML, SVG, PNG]
	 *
	 * @throws \App\Exceptions\AppException
	 *
	 * @return \Milon\Barcode\path|string
	 */
	public function createQrCodeForUser($type = 'PNG'): string
	{
		return $this->createQrCode($this->getOtpAuthUrl($this->secretKey, \App\User::getUser()->get('userName')), $type);
	}

	/**
	 * Create QR code.
	 *
	 * @param string $otpAuthUrl
	 * @param string $type       - acceptable types [HTML, SVG, PNG]
	 *
	 * @throws \App\Exceptions\AppException
	 *
	 * @return \Milon\Barcode\path|string - HTML code
	 */
	private function createQrCode($otpAuthUrl, $type = 'HTML'): string
	{
		$qrCodeGenerator = new \Milon\Barcode\DNS2D();
		$qrCodeGenerator->setStorPath(sys_get_temp_dir());
		switch ($type) {
			case 'HTML':
				return $qrCodeGenerator->getBarcodeHTML($otpAuthUrl, 'QRCODE');
			case 'SVG':
				return $qrCodeGenerator->getBarcodeSVG($otpAuthUrl, 'QRCODE');
			case 'PNG':
				return '<img src="data:image/png;base64,' . $qrCodeGenerator->getBarcodePNG($otpAuthUrl, 'QRCODE', 10, 10) . '" alt="QR code" class="col-auto p-0" />';
			default:
				break;
		}
		throw new \App\Exceptions\AppException('LBL_NOT_EXIST: ' . $type);
	}
}
