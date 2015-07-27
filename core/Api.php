<?php
/**
 * Basic communication file
 * @package YetiForce.API
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
Core_Loader::import('libraries/Requests/Requests.php');

class Core_Api
{

	protected static $_instance;
	protected $url;
	
	function __construct()
	{
		Requests::register_autoloader();
		$this->url = Config::get('crmPath').'api/webservice/';
		
	}

	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function call($method, $data)
	{
		$crmPath = $this->url.$method;
		$request = Requests::post($crmPath, [], ['data' => $data]);
		$response = Core_Json::decode($request->body);
		//echo "<pre>";var_dump($response);
		return $response;
	}

	public function authentication($email, $password)
	{
		$request = $this->call('Users/authentication', ['email' => $email, 'password' => $password]);
		return $request;
	}
}
