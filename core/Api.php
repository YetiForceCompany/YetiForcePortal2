<?php
require_once('libraries/Requests/Requests.php');

class Core_Api
{

	function __construct()
	{
		Requests::register_autoloader();
	}

	public static function call($method, $data)
	{
		$crmPath = Config::get('crmPath');
		$crmPath .= 'api/portal.php';
		$request = Requests::post($crmPath, [], ['method' => $method, 'data' => $data]);
	}
}
