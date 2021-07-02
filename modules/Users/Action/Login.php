<?php
/**
 * User action login file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

use App\Config;

/**
 * User action login class.
 */
class Login extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/** {@inheritdoc} */
	public function loginRequired(): bool
	{
		return false;
	}

	/** {@inheritdoc} */
	public function process()
	{
		$url = Config::$portalUrl;
		$this->checkBruteForce();
		try {
			if ($this->request->isEmpty('mode')) {
				$this->login($this->request->getByType('email', \App\Purifier::TEXT), $this->request->getRaw('password'));
			} else {
				$twoFactorAuth = $_SESSION['2fa'];
				unset($_SESSION['2fa']);
				$this->login($twoFactorAuth['email'], $twoFactorAuth['password'], $this->request->getByType('token', \App\Purifier::ALNUM));
			}
		} catch (\Throwable $th) {
			if (412 === $th->getCode()) {
				$url .= 'index.php?module=Users&view=Login&mode=2fa';
				$_SESSION['2fa'] = [
					'email' => $this->request->getByType('email', \App\Purifier::TEXT),
					'password' => $this->request->getRaw('password'),
				];
			} else {
				$_SESSION['login_errors'][] = $th->getMessage();
			}
		}
		header('Location: ' . $url);
	}

	/**
	 * Login to portal.
	 *
	 * @param string $email
	 * @param string $password
	 * @param string $token
	 *
	 * @return void
	 */
	public function login(string $email, string $password, string $token = ''): void
	{
		$userInstance = \App\User::getUser();
		$userInstance->set('language', $this->request->getByType('language', \App\Purifier::STANDARD));
		$response = \App\Api::getInstance()
			->call('Users/Login', [
				'userName' => $email,
				'password' => $password,
				'code' => $token,
				'params' => [
					'version' => \App\Config::$version,
					'language' => \App\Language::getLanguage(),
					'ip' => \App\Server::getRemoteIp(),
					'fromUrl' => \App\Config::$portalUrl,
					'deviceId' => $this->request->getByType('fingerprint', \App\Purifier::ALNUM_EXTENDED),
				],
			], 'post');
		if ($response && !(isset($response['code']) && 401 === $response['code'])) {
			session_regenerate_id(true);
			\App\Controller\Headers::generateCspToken();
			$userInstance->set('userName', $email);
			$userInstance->set('deviceId', $this->request->getByType('fingerprint', \App\Purifier::ALNUM_EXTENDED));
			foreach ($response as $key => $value) {
				$userInstance->set($key, $value);
			}
			if ($response['2faObligatory'] && 'PLL_AUTHY_TOTP' === $response['authy_methods']) {
				\App\Process::addEvent([
					'name' => 'ShowAuthy2faModal',
					'priority' => 7,
					'execution' => 'constant',
					'type' => 'modal',
					'url' => 'index.php?module=Users&view=TwoFactorAuthenticationModal',
				]);
			}
		}
	}

	/**
	 * Check brute force.
	 *
	 * @return void
	 */
	public function checkBruteForce(): void
	{
		if (!Config::$bruteForceIsEnabled) {
			return;
		}
		$ip = $_SERVER['REMOTE_ADDR'];
		if (empty(Config::$bruteForceDayLimit) || (!empty(Config::$bruteForceTrustedIp) && \in_array($ip, Config::$bruteForceTrustedIp))) {
			return;
		}
		if (\App\Cache::isBase()) {
			throw new \App\Exceptions\NoPermitted('Cache is not working');
		}
		if (\App\Cache::has('checkBruteForce', $ip)) {
			$row = \App\Cache::get('checkBruteForce', $ip);
			if (date('Y-m-d', strtotime($row['last_request'])) === date('Y-m-d')) {
				$row['counter'] = $row['counter'] + 1;
			} else {
				$row['counter'] = 1;
			}
			$row['last_request'] = date('Y-m-d H:i:s');
			\App\Cache::save('checkBruteForce', $ip, $row, 0);
			if ($row['counter'] > (int) Config::$bruteForceDayLimit) {
				throw new \App\Exceptions\NoPermitted('Day limit exceeded | ' . $ip, 1100);
			}
		} else {
			\App\Cache::save('checkBruteForce', $ip, [
				'last_request' => date('Y-m-d H:i:s'),
				'counter' => 1,
			], 0);
		}
	}
}
