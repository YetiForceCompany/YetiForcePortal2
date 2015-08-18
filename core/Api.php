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

	/**
	 * Api class constructor
	 */
	function __construct()
	{
		$this->url = \Config::get('crmPath') . 'api/webservice/';
	}

	/**
	 * Initiate API instance
	 * @return Core::Api instance
	 */
	public static function getInstance()
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * 
	 * @param string $method 
	 * @param array $data
	 * @return array
	 */
	public function call($method, $data, $requestType = 'post')
	{
		$crmPath = $this->url . $method;
		$rawRequest = $data;
		if (\Config::getBoolean('encryptDataTransfer') && $requestType != 'get') {
			$data = $this->encryptData($data);
		}
		
		$startTime = microtime(true);
		$request = Requests::$requestType($crmPath, $this->getHead(),$data);
		$rawResponse = $request->body;
		
		if ($request->headers->getValues('encrypted')[0] == 1) {
			$rawResponse = $this->decryptData($rawResponse);
		}
		$response = Core\Json::decode($rawResponse);
		
		if (\Config::getBoolean('debugApi')) {
			$debugApi = [
				'date' => date('Y-m-d H:i:s',$startTime),
				'time' =>round(microtime(true) - $startTime, 4),
				'method' => $method,
				'rawRequest' => $rawRequest,
				'rawResponse' => $rawResponse,
				'response' => $response,
				'request' => $request->raw,
			];
			$_SESSION['debugApi'][] = $debugApi;
		}
		
		if (\Config::getBoolean('logs')) {
			$this->addLogs($method, $data, $response);
		}
		
		if (isset($response['error'])) {
			$_SESSION['systemError'][] = $response['error'];
		}

		if (isset($response['result']))
			return $response['result'];
	}

	/**
	 * 
	 * @return array
	 */
	public function getHead()
	{
		return [
			'language' => Language::getLanguage(),
			'version' => VERSION,
			'apiKey' => \Config::get('apiKey'),
			'encrypted' => \Config::getBoolean('encryptDataTransfer') ? 1 : 0,
			'ip' => $this->getRemoteIP(),
			'fromUrl' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'],
			'sessionID' => 'xx',
		];
	}

	/**
	 * 
	 * @param string $method
	 * @param array $data
	 * @param array $response
	 */
	public function addLogs($method, $data, $response)
	{
		$content = '============ ' . date('Y-m-d H:i:s') . ' ============' . PHP_EOL;
		$content .= 'Metod: ' . $method . PHP_EOL;
		$content .= 'Request: ' . print_r($data, true) . PHP_EOL;
		$content .= 'Response: ' . print_r($response, true) . PHP_EOL;
		file_put_contents($this->log, $content, FILE_APPEND);
	}

	/**
	 * 
	 * @param array $data
	 * @return string Encrypted string
	 */
	public function encryptData($data)
	{

		$publicKey = 'file://' . YF_ROOT . DIRECTORY_SEPARATOR . \Config::get('publicKey');
		openssl_public_encrypt(Core\Json::encode($data), $encrypted, $publicKey);
		return $encrypted;
	}

	/**
	 * 
	 * @param array $data
	 * @return array Decrypted string
	 * @throws AppException
	 */
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

	/**
	 * 
	 * @param bool $onlyIP
	 * @return string
	 */
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
