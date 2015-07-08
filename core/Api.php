<?php
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
		var_dump($crmPath);
		//$request = Requests::post($crmPath, [], ['method' => $method, 'data' => $data]);
	}

	public function doLogin($email, $password)
	{
		//$crmPath = $this->url.$method;
		$crmPath = $this->url.'Users/authentication';
		$request = Requests::post($crmPath, [], ['data' => ['email' => $email, 'password' => $password]]);
		var_dump($request->body);
		//$request = Requests::call('', ['method' => $method, 'data' => $data]);
	}
}
