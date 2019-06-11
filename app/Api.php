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

class Api
{
	/**
	 * Instance.
	 *
	 * @var self
	 */
	protected static $instance;
	protected $url;
	protected $header = [];

	/**
	 * Options.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Api class constructor.
	 *
	 * @param mixed $options
	 * @param array $header
	 */
	public function __construct(array $header, array $options)
	{
		$this->url = Config::$crmUrl . 'webservice/';
		$this->options = $options;
		$this->header = $header;
	}

	/**
	 * Initiate API instance.
	 *
	 * @return self instance
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			$userInstance = User::getUser();
			$header = [
				'Content-Type' => 'application/json',
				'X-ENCRYPTED' => Config::$encryptDataTransfer ? 1 : 0,
				'X-API-KEY' => Config::$apiKey,
				'X-TOKEN' => $userInstance->has('logged') ? $userInstance->get('token') : null,
			];
			if ($userInstance->has('companyId')) {
				$header['X-PARENT-ID'] = $userInstance->get('companyId');
			}
			self::$instance = new self($header, [
				'auth' => [Config::$serverName, Config::$serverPass]
			]);
		}

		return self::$instance;
	}

	/**
	 * Call API method.
	 *
	 * @param string $method
	 * @param array  $data
	 * @param string $requestType
	 *
	 * @return array|false
	 */
	public function call(string $method, array $data = [], string $requestType = 'get')
	{
		$crmPath = $this->url . $method;
		$rawRequest = $data;
		$startTime = microtime(true);
		$headers = $this->getHeaders();
		$options = $this->getOptions();
		if (\in_array($requestType, ['get', 'delete'])) {
			$request = (new \GuzzleHttp\Client())->request($requestType, $crmPath, ['headers' => $headers] + $options);
		} else {
			$data = Json::encode($data);
			if (Config::$encryptDataTransfer) {
				$data = $this->encryptData($data);
			}
			$request = (new \GuzzleHttp\Client())->request($requestType, $crmPath, ['headers' => $headers, 'body' => $data] + $options);
		}
		$rawResponse = (string) $request->getBody();
		if (1 == $request->getHeader('encrypted')[0]) {
			$rawResponse = $this->decryptData($rawResponse);
		}
		$response = Json::decode($rawResponse);
		if (\App\Config::$debugApi) {
			$debugApi = [
				'date' => date('Y-m-d H:i:s', $startTime),
				'time' => round(microtime(true) - $startTime, 4),
				'method' => $method,
				'requestType' => strtoupper($requestType),
				'rawRequest' => [$headers, $rawRequest],
				'rawResponse' => $rawResponse,
				'response' => $response,
				'request' => (string) $request->getBody(),
				'trace' => Debug::getBacktrace()
			];
			$_SESSION['debugApi'][] = $debugApi;
		}
		if (Config::$logs) {
			$this->addLogs($method, $data, $response, $rawResponse);
		}
		if (empty($response)) {
			throw new \App\AppException($rawResponse, 500);
		}
		if (isset($response['error'])) {
			$_SESSION['systemError'][] = $response['error'];
			throw new \App\AppException($response['error']['message'], $response['error']['code']);
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
	public function getHeaders(): array
	{
		return $this->header;
	}

	/**
	 * Get options.
	 *
	 * @return array
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	/**
	 * @param array $data
	 *
	 * @return string Encrypted string
	 */
	public function encryptData($data): string
	{
		$publicKey = 'file://' . YF_ROOT . \DIRECTORY_SEPARATOR . Config::$publicKey;
		openssl_public_encrypt(Json::encode($data), $encrypted, $publicKey, \OPENSSL_PKCS1_OAEP_PADDING);
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
		$privateKey = 'file://' . YF_ROOT . \DIRECTORY_SEPARATOR . Config::$privateKey;
		if (!$privateKey = openssl_pkey_get_private($privateKey)) {
			throw new AppException('Private Key failed');
		}
		$privateKey = openssl_pkey_get_private($privateKey);
		openssl_private_decrypt($data, $decrypted, $privateKey, \OPENSSL_PKCS1_OAEP_PADDING);
		return $decrypted;
	}

	/**
	 * @param string $method
	 * @param array  $data
	 * @param array  $response
	 * @param mixed  $rawResponse
	 */
	public function addLogs($method, $data, $response, $rawResponse = false)
	{
		$value['method'] = $method;
		$value['data'] = $data;
		if ($rawResponse) {
			$value['rawResponse'] = $rawResponse;
		}
		$value['response'] = $response;
		\App\Log::info($value, 'Api');
	}

	/**
	 * Set custom headers.
	 *
	 * @param array $headers
	 *
	 * @return $this
	 */
	public function setCustomHeaders(array $headers): self
	{
		$this->header = $this->getHeaders();
		foreach ($headers as $key => $value) {
			$this->header[$key] = $value;
		}
		return $this;
	}
}
