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
			$email = $this->request->getByType('email', \App\Purifier::TEXT);
			$password = $this->request->getRaw('password');
			$userInstance = \App\User::getUser();
			$userInstance->set('language', $this->request->getByType('language', \App\Purifier::STANDARD));
			if ($this->request->isEmpty('mode')) {
				$userInstance->login($email, $password);
			} else {
				$twoFactorAuth = $_SESSION['2fa'];
				unset($_SESSION['2fa']);
				$userInstance->login($twoFactorAuth['email'], $twoFactorAuth['password'], $this->request->getByType('token', \App\Purifier::ALNUM));
			}
		} catch (\Throwable $th) {
			if (412 === $th->getCode()) {
				$url .= 'index.php?module=Users&view=Login&mode=2fa';
				$_SESSION['2fa'] = [
					'email' => $email,
					'password' => $password,
				];
			} else {
				$_SESSION['login_errors'][] = $th->getMessage();
			}
		}
		header('Location: ' . $url);
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
			throw new \App\Exceptions\NoPermitted('Cache is not working', );
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
