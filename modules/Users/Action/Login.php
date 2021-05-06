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
		$this->checkBruteForce();
		$email = $this->request->getByType('email', \App\Purifier::TEXT);
		$password = $this->request->getRaw('password');
		$userInstance = \App\User::getUser();
		$userInstance->set('language', $this->request->getByType('language', \App\Purifier::STANDARD));
		try {
			$userInstance->login($email, $password);
		} finally {
			header('Location: ' . Config::$portalUrl);
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
			throw new \App\Exceptions\NoPermitted('Cache is not working', 1101);
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
