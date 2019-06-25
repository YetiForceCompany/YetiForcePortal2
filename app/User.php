<?php
/**
 * User class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

class User extends BaseModel
{
	/**
	 * Permissions based on user.
	 */
	const USER_PERMISSIONS = 1;
	/**
	 * All records of account assigned directly to contact.
	 */
	const ACCOUNTS_RELATED_RECORDS = 2;
	/**
	 * All related records of account assigned directly to contact and accounts lower in hierarchy.
	 */
	const ACCOUNTS_RELATED_RECORDS_AND_LOWER_IN_HIERARCHY = 3;
	/**
	 * All related records of account assigned directly to contact and accounts from hierarchy.
	 */
	const ACCOUNTS_RELATED_RECORDS_IN_HIERARCHY = 4;

	protected static $user = false;

	/**
	 * Get User objec.
	 *
	 * @return self
	 */
	public static function getUser(): self
	{
		if (!self::$user) {
			$user = Session::has('user') ? Session::get('user') : false;
			if ($user) {
				self::$user = new self($user);
			} else {
				self::$user = new self();
			}
		}
		return self::$user;
	}

	public function hasLogin()
	{
		return $this->has('logged') ? $this->get('logged') : false;
	}

	/**
	 * Login to portal.
	 *
	 * @param string $email
	 * @param string $password
	 *
	 * @return bool
	 */
	public function login(string $email, string $password): bool
	{
		$params = [
			'version' => Config::$version,
			'language' => Language::getLanguage(),
			'ip' => Server::getRemoteIp(),
			'fromUrl' => Config::$portalUrl
		];
		$response = Api::getInstance()->call('Users/Login', ['userName' => $email, 'password' => $password, 'params' => $params], 'post');
		if ($response && !(isset($response['code']) && 401 === $response['code'])) {
			session_regenerate_id(true);
			foreach ($response as $key => $value) {
				$this->set($key, $value);
			}
			return true;
		}
		return false;
	}

	/**
	 * Function to set the value for a given key.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return BaseModel
	 */
	public function set(string $key, $value)
	{
		$_SESSION['user'][$key] = $value;
		$this->valueMap[$key] = $value;
		return $this;
	}

	/**
	 * Is permitted to module.
	 *
	 * @param string $module
	 *
	 * @return bool
	 */
	public function isPermitted(string $module): bool
	{
		return isset($this->getModulesList()[$module]);
	}

	/**
	 * Get modules list.
	 *
	 * @return array
	 */
	public function getModulesList(): array
	{
		$modules = Session::get('Modules');
		if (!empty($modules)) {
			return $modules;
		}
		$modules = Api::getInstance()->call('Modules');
		Session::set('Modules', $modules);
		return $modules;
	}

	/**
	 * Get companies.
	 *
	 * @return array
	 */
	public function getCompanies()
	{
		if ($this->isEmpty('type') || $this->get('type') < 3) {
			return false;
		}
		$companies = Session::get('Companies');
		if (!empty($companies)) {
			return $companies;
		}
		$companies = Api::getInstance()->call('Accounts/Hierarchy');
		Session::set('Companies', $companies);
		return $companies;
	}

	/**
	 * Get preferences.
	 *
	 * @param mixed $key
	 *
	 * @throws AppException
	 *
	 * @return mixed
	 */
	public function getPreferences($key = false)
	{
		$preferences = $this->get('preferences');
		if (empty($preferences)) {
			throw new AppException('lack of user preferences');
		}
		if ($key && isset($preferences[$key])) {
			return $preferences[$key];
		}
		if ($key && !isset($preferences[$key])) {
			return null;
		}
		return $preferences;
	}
}
