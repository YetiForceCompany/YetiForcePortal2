<?php
/**
 * Basic communication file.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com))
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

use Requests;

class Api
{
	protected static $_instance;
	protected $url;
	protected $header;
	protected $log = YF_ROOT . DIRECTORY_SEPARATOR . 'cache/logs/api.log';

	/**
	 * Api class constructor.
	 */
	public function __construct()
	{
		$this->url = Config::get('crmPath') . 'webservice/';
	}

	/**
	 * Initiate API instance.
	 *
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
	 * @param string $method
	 * @param array  $data
	 *
	 * @return array
	 */
	public function call($method, $data = [], $requestType = 'get')
	{
		$crmPath = $this->url . $method;
		$rawRequest = $data;
		$startTime = microtime(true);
		$headers = $this->getHeaders();
		$options = $this->getOptions();
		if (in_array($requestType, ['get', 'delete'])) {
			$request = Requests::$requestType($crmPath, $headers, $options);
		} else {
			$data = Json::encode($data);
			if (Config::getBoolean('encryptDataTransfer') && $requestType !== 'get') {
				$data = $this->encryptData($data);
			}
			$request = Requests::$requestType($crmPath, $headers, $data, $options);
		}
		$rawResponse = $request->body;
		if ($request->headers->getValues('X-ENCRYPTED')[0] == 1) {
			$rawResponse = $this->decryptData($rawResponse);
		}
		$response = Json::decode($rawResponse);
		if (Config::getBoolean('debugApi')) {
			$debugApi = [
				'date' => date('Y-m-d H:i:s', $startTime),
				'time' => round(microtime(true) - $startTime, 4),
				'method' => $method,
				'requestType' => strtoupper($requestType),
				'rawRequest' => [$headers, $rawRequest],
				'rawResponse' => $rawResponse,
				'response' => $response,
				'request' => $request->raw,
				'trace' => Functions::getBacktrace()
			];
			$_SESSION['debugApi'][] = $debugApi;
		}
		if (Config::getBoolean('logs')) {
			$this->addLogs($method, $data, $response, $rawResponse);
		}
		if (isset($response['error'])) {
			return $_SESSION['systemError'][] = $response['error'];
		}
		if (isset($response['result'])) {
			return $response['result'];
		}
	}

	/**
	 * Headers.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		if (empty($this->header)) {
			$userInstance = User::getUser();
			$return = [
				'Content-Type' => 'application/json',
				'X-ENCRYPTED' => Config::getBoolean('encryptDataTransfer') ? 1 : 0,
				'X-API-KEY' => Config::get('apiKey'),
				'X-TOKEN' => $userInstance->has('logged') ? $userInstance->get('token') : null,
			];
			if ($userInstance->has('CompanyId')) {
				$return['X-PARENT-ID'] = $userInstance->get('CompanyId');
			}
			$this->header = $return;
		}
		return $this->header;
	}

	public function getOptions()
	{
		return [
			'auth' => [Config::get('serverName'), Config::get('serverPass')]
		];
	}

	/**
	 * @param array $data
	 *
	 * @return string Encrypted string
	 */
	public function encryptData($data)
	{
		$publicKey = 'file://' . YF_ROOT . DIRECTORY_SEPARATOR . Config::get('publicKey');
		openssl_public_encrypt(Json::encode($data), $encrypted, $publicKey);
		return $encrypted;
	}

	/**
	 * @param array $data
	 *
	 * @throws AppException
	 *
	 * @return array Decrypted string
	 */
	public function decryptData($data)
	{
		$privateKey = 'file://' . YF_ROOT . DIRECTORY_SEPARATOR . Config::get('privateKey');
		if (!$privateKey = openssl_pkey_get_private($privateKey)) {
			throw new AppException('Private Key failed');
		}
		$privateKey = openssl_pkey_get_private($privateKey);
		openssl_private_decrypt($data, $decrypted, $privateKey);
		return $decrypted;
	}

	/**
	 * @param string $method
	 * @param array  $data
	 * @param array  $response
	 */
	public function addLogs($method, $data, $response, $rawResponse = false)
	{
		$content = '============ ' . date('Y-m-d H:i:s') . ' ============' . PHP_EOL;
		$content .= 'Metod: ' . $method . PHP_EOL;
		$content .= 'Request: ' . print_r($data, true) . PHP_EOL;
		if ($rawResponse) {
			$content .= 'Response (raw): ' . print_r($rawResponse, true) . PHP_EOL;
		}
		$content .= 'Response: ' . print_r($response, true) . PHP_EOL;
		file_put_contents($this->log, $content, FILE_APPEND);
	}

	/**
	 * Set custom headers.
	 *
	 * @param array $headers
	 *
	 * @return $this
	 */
	public function setCustomHeaders($headers)
	{
		$this->header = $this->getHeaders();
		foreach ($headers as $key => $value) {
			$this->header[$key] = $value;
		}
		return $this;
	}
}
