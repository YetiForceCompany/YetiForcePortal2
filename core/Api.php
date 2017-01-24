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
	 * @return self instance
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
		$startTime = microtime(true);
		$headers = $this->getHeaders();
		$options = $this->getOptions();
		if (in_array($requestType, ['get', 'delete'])) {
			$request = Requests::$requestType($crmPath, $headers, $options);
		} else {
			$data = Core\Json::encode($data);
			if (\Config::getBoolean('encryptDataTransfer') && $requestType !== 'get') {
				$data = $this->encryptData($data);
			}
			$request = Requests::$requestType($crmPath, $headers, $data, $options);
		}
		$rawResponse = $request->body;
		if ($request->headers->getValues('X-ENCRYPTED')[0] == 1) {
			$rawResponse = $this->decryptData($rawResponse);
		}
		$response = Core\Json::decode($rawResponse);
		if (\Config::getBoolean('debugApi')) {
			$debugApi = [
				'date' => date('Y-m-d H:i:s', $startTime),
				'time' => round(microtime(true) - $startTime, 4),
				'method' => $method,
				'requestType' => strtoupper($requestType),
				'rawRequest' => [$headers, $rawRequest],
				'rawResponse' => $rawResponse,
				'response' => $response,
				'request' => $request->raw,
				'trace' => \FN::getBacktrace()
			];
			$_SESSION['debugApi'][] = $debugApi;
		}
		if (\Config::getBoolean('logs')) {
			$this->addLogs($method, $data, $response);
		}
		if (isset($response['error'])) {
			$_SESSION['systemError'][] = $response['error'];
			if ($response['error']['code'] === 401) {
				session_destroy();
			}
		}
		if (isset($response['result'])) {
			return $response['result'];
		}
	}

	/**
	 * 
	 * @return array
	 */
	public function getHeaders()
	{
		$userInstance = User::getUser();
		return [
			'Content-Type' => 'application/json',
			'X-ENCRYPTED' => \Config::getBoolean('encryptDataTransfer') ? 1 : 0,
			'X-API-KEY' => \Config::get('apiKey'),
			'X-TOKEN' => $userInstance->has('logged') ? $userInstance->get('token') : null,
		];
	}

	public function getOptions()
	{
		return [
			'auth' => [\Config::get('serverName'), \Config::get('serverPass')]
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
}
