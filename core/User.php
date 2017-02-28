<?php
/**
 * User class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;

use Core\Session;

class User extends BaseModel
{

	protected static $user = false;

	public static function getUser()
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

	/**
	 * Function to set the value for a given key
	 * @param $key
	 * @param $value
	 * @return Core\BaseModel
	 */
	public function set($key, $value)
	{
		$_SESSION['user'][$key] = $value;
		$this->valueMap[$key] = $value;
		return $this;
	}

	/**
	 * Checking login
	 * @param \Core\Request $request
	 * @throws \AppException
	 */
	public function checkLogin(\Core\Request $request)
	{
		if (!$this->hasLogin()) {
			header('Location: index.php');
			throw new \AppException('Login is required');
		}
	}

	public function hasLogin()
	{
		return $this->has('logged') ? $this->get('logged') : false;
	}

	public function login($email, $password)
	{
		$params = [
			'version' => VERSION,
			'language' => Language::getLanguage(),
			'ip' => \FN::getRemoteIP(),
			'fromUrl' => \Config::get('portalPath')
		];
		$response = Api::getInstance()->call('Users/Login', ['userName' => $email, 'password' => $password, 'params' => $params], 'post');
		if ($response) {
			session_regenerate_id(true);
			foreach ($response as $key => $value) {
				$this->set($key, $value);
			}
		}
		return true;
	}

	public function isPermitted($module)
	{
		return isset($this->getModulesList()[$module]);
	}

	/**
	 * Get modules list
	 * @return array
	 */
	public function getModulesList()
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
	 * Get companies
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
	 * Get preferences
	 * @return mixed
	 * @throws \AppException
	 */
	public function getPreferences($key = false)
	{
		$preferences = $this->get('preferences');
		if (empty($preferences)) {
			throw new \AppException('lack of user preferences');
		}
		return $key ? $preferences[$key] : $preferences;
	}
}
