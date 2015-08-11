<?php
/**
 * User class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;

class User extends BaseModel
{

	protected static $user = false;

	public static function getUser()
	{
		if (!self::$user) {
			$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
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

	public function doLogin($email, $password)
	{
		$api = Api::getInstance();
		$response = $api->call('Users/Authentication', ['email' => $email, 'password' => $password]);
		if ($response) {
			session_regenerate_id(true);
			foreach ($response as $key => $value) {
				$this->set($key, $value);
			}
		}
		return $auth;
	}

	public function isPermitted($module)
	{
		return in_array($module, $this->getModulesList());
	}

	public function getModulesList()
	{
		if (isset($_SESSION['modules'])) {
			return $_SESSION['modules'];
		}
		$api = Api::getInstance();
		$modules = $api->call('Base/GetModulesList', [], 'get');
		$_SESSION['modules'] = $modules;
		return $modules;
	}
}
