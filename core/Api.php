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

		if (\Config::getBoolean('encryptDataTransfer')) {
			$data = $this->encryptData($data);
		}

		$request = Requests::post($crmPath, $this->getHead(), $data);
		$response = $request->body;

		if ($request->headers->getValues('encrypted')[0] == 1) {
			$response = $this->decryptData($response);
		}
		$response = Core\Json::decode($response);
		if (\Config::getBoolean('debug')) {
			$this->addLogs($method, $data, $response);
		}
		
		if (isset($response['error'])) {
			$_SESSION['systemError'][] = $response['error'];
		}

		if (isset($response['result']))
			return $response['result'];
	}

	public function getHead()
	{
		return [
			'language' => $_SESSION['language'],
			'version' => VERSION,
			'apiKey' => \Config::get('apiKey'),
			'encrypted' => \Config::getBoolean('encryptDataTransfer') ? 1 : 0,
			'ip' => $this->getRemoteIP(),
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
		$request = $this->call('Users/Authentication', ['email' => $email, 'password' => $password]);
		return $request;
	}

	public function encryptData($data)
	{

		$publicKey = 'file://' . YF_ROOT . DIRECTORY_SEPARATOR . \Config::get('publicKey');
		openssl_public_encrypt(Core\Json::encode($data), $encrypted, $publicKey);
		return $encrypted;
	}

	public function decryptData($data)
	{
		$privateKey = 'file://' . YF_ROOT . DIRECTORY_SEPARATOR . \Config::get('privateKey');
		if (!$privateKey = openssl_pkey_get_private($privateKey)) {
			throw new AppException('Private Key failed');
		}
		$privateKey = openssl_pkey_get_private($privateKey);
		openssl_private_decrypt($data, $decrypted, $privateKey);
		return $decrypted;
	}

	function getRemoteIP($onlyIP = false)
	{
		$address = $_SERVER['REMOTE_ADDR'];

		// append the NGINX X-Real-IP header, if set
		if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
			$remote_ip[] = 'X-Real-IP: ' . $_SERVER['HTTP_X_REAL_IP'];
		}
		// append the X-Forwarded-For header, if set
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remote_ip[] = 'X-Forwarded-For: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if (!empty($remote_ip) && $onlyIP == false) {
			$address .= '(' . implode(',', $remote_ip) . ')';
		}
		return $address;
	}
}
