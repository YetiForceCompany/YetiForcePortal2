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
		if (Config::getBoolean('encryptDataTransfer')) {
			$_SESSION['systemError'] = $response['error'];
		}
		$data = [
			'head' => $this->getHead(),
			'data' => $data,
		];
		$request = Requests::post($crmPath, [], $data);
		$response = Core\Json::decode($request->body);
		if (\Config::getBoolean('debug')) {
			$this->addLogs($method, $data, $response);
		}
		if (isset($response['error'])) {
			$_SESSION['systemError'] = $response['error'];
		}
		if (isset($response['result']))
			return $response['result'];
	}

	public function getHead()
	{
		return [
			'language' => $_SESSION['language'],
			'version' => VERSION,
			'encrypted' => \Config::getBoolean('encryptDataTransfer'),
		];
	}

	public function addLogs($method, $data, $response)
	{
		$content = '============ ' . date('Y-m-d H:i:s') . ' ============' . PHP_EOL;
		$content .= 'Metod: ' . $method . PHP_EOL;
		$content .= 'Request: ' . print_r($data, true) . PHP_EOL;
		$content .= 'Response: ' . print_r($response, true) . PHP_EOL;
		file_put_contents($this->log, $content, FILE_APPEND);
	}

	public function authentication($email, $password)
	{
		$request = $this->call('Users/authentication', ['email' => $email, 'password' => $password]);
		return $request;
	}

	public function encryptData($data)
	{
		$publicKey = 'file://' . \Config::get('publicKey');
		openssl_public_encrypt($data, $encrypted, $publicKey);
		return $encrypted;
	}

	public function decryptData($data)
	{
		$privateKey = 'file://' . \Config::get('privateKey');
		if (!$privateKey = openssl_pkey_get_private($privateKey)) {
			throw new AppException('Private Key failed');
		}
		$privateKey = openssl_pkey_get_private($privateKey);
		openssl_private_decrypt($data, $decrypted, $privateKey);
		return $decrypted;
	}
}
