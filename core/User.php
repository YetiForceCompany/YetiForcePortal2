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

	public function checkLogin(Core\Request $request)
	{
		if (!$this->hasLogin()) {
			header('Location: index.php');
			throw new AppException('Login is required');
		}
	}

	public function hasLogin()
	{
		return $this->has('logged') ? $this->get('logged') : false;
	}

	public function login($email, $password)
	{
		$api = Api::getInstance();
		$params = [
			'version' => VERSION,
			'language' => Language::getLanguage(),
			'ip' => \FN::getRemoteIP(),
			'fromUrl' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'],
		];
		$response = $api->call('Users/Login', ['userName' => $email, 'password' => $password, 'params' => $params]);
		if ($response) {
			session_regenerate_id(true);
			foreach ($response as $key => $value) {
				$this->set($key, $value);
			}
		}
		return $auth;
	}

	public function logout()
	{
		$api = Api::getInstance();
		$response = $api->call('Users/Logout', [], 'get');
		if ($response) {
			session_destroy();
		}
	}

	public function isPermitted($module)
	{
		return isset($this->getModulesList()[$module]);
	}

	public function getModulesList()
	{
		$modules = Session::get('modules');
		if (!empty($modules)) {
			return $modules;
		}
		$api = Api::getInstance();
		$modules = $api->call('Base/GetModulesList', [], 'get');
		Session::set('modules', $modules);
		return $modules;
	}
}
