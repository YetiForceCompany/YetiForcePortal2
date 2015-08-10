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
			if($user){
				self::$user = new self($user);
			}  else {
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
		return $this->get('logged');
	}

	public function doLogin($email, $password)
	{
		$api = Api::getInstance();
		$auth = $api->authentication($email, $password);
		$resp = [];
		if (isset($auth['auth']) && $auth['auth'] === true) {
			session_regenerate_id(true);
			$this->set('logged', true);
			$this->set('id', $auth['userID']);
			$this->set('name', $auth['userID']);
			$this->set('email', $auth['fullName']);
			$resp = ['auth' => $auth['email']];
		} else {
			$resp['errorExists'] = true;
			//$resp['massage'] = $auth['error'];
		}
		return $resp;
	}
}
