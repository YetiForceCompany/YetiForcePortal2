<?php
/**
 * Basic communication file
 * @package YetiForce.API
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;

use Requests,
	Core;

class Api
{

	protected static $_instance;
	protected $url;
	protected $log = 'cache/logs/api.log';

	function __construct()
	{
		$this->url = \Config::get('crmPath') . 'api/webservice/';
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
		$crmPath = $this->url . $method;
		$request = Requests::post($crmPath, [], ['data' => $data]);
		$response = Core\Json::decode($request->body);
		if (\Config::getBoolean('debug')) {
			$content = '============ ' . date('Y-m-d H:i:s') . ' ============' . PHP_EOL;
			$content .= 'Metod: ' . $method . PHP_EOL;
			$content .= 'Request: ' . print_r($data, true) . PHP_EOL;
			$content .= 'Response: ' . print_r($response, true) . PHP_EOL;
			file_put_contents($this->log, $content, FILE_APPEND);
		}
		return $response;
	}

	public function authentication($email, $password)
	{
		$request = $this->call('Users/authentication', ['email' => $email, 'password' => $password]);
		return $request;
	}
}
