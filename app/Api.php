<?php
/**
 * Basic communication file.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com))
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

class Api
{
	/** @var self API Instance */
	protected static $instance;

	/** @var array Headers. */
	protected $header = [];

	/** @var \GuzzleHttp\Client Guzzle http client */
	protected $httpClient;

	/** @var array The default configuration of GuzzleHttp. */
	protected $options = [];

	/**
	 * Api class constructor.
	 *
	 * @param array $header
	 * @param array $options
	 */
	public function __construct(array $header, array $options)
	{
		$this->header = $header;
		$this->httpClient = new \GuzzleHttp\Client(array_merge($options, Config::$options));
	}

	/**
	 * Initiate API instance.
	 *
	 * @return self instance
	 */
	public static function getInstance(): self
	{
		if (!isset(self::$instance)) {
			$userInstance = User::getUser();
			$header = [
				'User-Agent' => 'YetiForcePortal2',
				'X-Encrypted' => Config::$encryptDataTransfer ? 1 : 0,
				'X-Api-Key' => Config::$apiKey,
				'Content-Type' => 'application/json',
			];
			if ($userInstance->has('logged')) {
				$header['X-Token'] = $userInstance->get('token');
			}
			if ($userInstance->has('companyId')) {
				$header['X-Parent-Id'] = $userInstance->get('companyId');
			}
			self::$instance = new self($header, [
				'http_errors' => false,
				'base_uri' => Config::$apiUrl . 'Portal/',
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
	 * @param string $requestType Default get
	 *
	 * @return array|false
	 */
	public function call(string $method, array $data = [], string $requestType = 'get')
	{
		$rawRequest = $data;
		$startTime = microtime(true);
		$headers = $this->getHeaders();
		try {
			if (\in_array($requestType, ['get', 'delete'])) {
				$response = $this->httpClient->request($requestType, $method, ['headers' => $headers]);
			} else {
				$data = Json::encode($data);
				if (Config::$encryptDataTransfer) {
					$data = $this->encryptData($data);
				}
				$response = $this->httpClient->request($requestType, $method, ['headers' => $headers, 'body' => $data]);
			}
			$rawResponse = (string) $response->getBody();
			$encryptedHeader = $response->getHeader('encrypted');
			if ($encryptedHeader && 1 == $response->getHeader('encrypted')[0]) {
				$rawResponse = $this->decryptData($rawResponse);
			}
			$responseBody = Json::decode($rawResponse);
		} catch (\Throwable $e) {
			if (Config::$logs) {
				$this->addLogs($method, $data, '', $e->__toString());
			}
			throw new Exceptions\AppException('An error occurred while communicating with the CRM', 500, $e);
		}
		if (\App\Config::$debugApi) {
			$_SESSION['debugApi'][] = [
				'date' => date('Y-m-d H:i:s', $startTime),
				'time' => round(microtime(true) - $startTime, 2),
				'method' => $method,
				'requestType' => strtoupper($requestType),
				'rawRequest' => [$headers, $rawRequest],
				'rawResponse' => $rawResponse,
				'response' => $responseBody,
				'trace' => Debug::getBacktrace()
			];
		}
		if (Config::$logs) {
			$this->addLogs($method, $data, $response, $rawResponse);
		}
		if (empty($responseBody) || 200 !== $response->getStatusCode()) {
			throw new Exceptions\AppException('API returned an error: ' . $response->getReasonPhrase(), $response->getStatusCode());
		}
		if (isset($responseBody['error'])) {
			$_SESSION['systemError'][] = $responseBody['error'];
			throw new Exceptions\AppException($responseBody['error']['message'], $responseBody['error']['code'] ?? 500);
		}
		if (isset($responseBody['result'])) {
			return $responseBody['result'];
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
	 * @param array $data
	 *
	 * @return string Encrypted string
	 */
	public function encryptData($data): string
	{
		$publicKey = 'file://' . ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . Config::$publicKey;
		openssl_public_encrypt(Json::encode($data), $encrypted, $publicKey, OPENSSL_PKCS1_OAEP_PADDING);
		return $encrypted;
	}

	/**
	 * @param array $data
	 *
	 * @throws \App\Exceptions\AppException
	 *
	 * @return array Decrypted string
	 */
	public function decryptData($data)
	{
		$privateKey = 'file://' . ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . Config::$privateKey;
		if (!$privateKey = openssl_pkey_get_private($privateKey)) {
			throw new Exceptions\AppException('Private Key failed');
		}
		$privateKey = openssl_pkey_get_private($privateKey);
		openssl_private_decrypt($data, $decrypted, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);
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
	 * @return self
	 */
	public function setCustomHeaders(array $headers): self
	{
		$this->header = $this->getHeaders();
		foreach ($headers as $key => $value) {
			$this->header[strtolower($key)] = $value;
		}
		return $this;
	}
}
