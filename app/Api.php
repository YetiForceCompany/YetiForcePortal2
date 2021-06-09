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
				'User-Agent' => 'YetiForce Portal',
				'X-Encrypted' => Config::$encryptDataTransfer ? 1 : 0,
				'X-Api-Key' => Config::$apiKey,
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
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
				'auth' => [Config::$serverName, Config::$serverPass],
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
			$contentType = explode(';', $response->getHeaderLine('Content-Type'));
			$rawResponse = $response->getBody()->getContents();
			if ($headers['Accept'] !== reset($contentType)) {
				if (Config::$apiErrorLogs || Config::$apiAllLogs) {
					\App\Log::info([
						'request' => ['date' => date('Y-m-d H:i:s', $startTime), 'requestType' => strtoupper($requestType), 'method' => $method, 'headers' => $headers, 'rawBody' => $rawRequest, 'body' => $data],
						'response' => ['time' => round(microtime(true) - $startTime, 2), 'status' => $response->getStatusCode(), 'reasonPhrase' => $response->getReasonPhrase(), 'error' => "Invalid response content type\n Accept:{$headers['Accept']} <> {$response->getHeaderLine('Content-Type')}", 'headers' => $response->getHeaders(), 'rawBody' => $rawResponse],
					], 'Api');
				}
				throw new Exceptions\AppException('Invalid response content type', 500);
			}
			$encryptedHeader = $response->getHeader('encrypted');
			if ($encryptedHeader && 1 == $response->getHeader('encrypted')[0]) {
				$rawResponse = $this->decryptData($rawResponse);
			}
			$responseBody = Json::decode($rawResponse);
		} catch (\Throwable $e) {
			if (Config::$apiErrorLogs || Config::$apiAllLogs) {
				\App\Log::info([
					'request' => ['date' => date('Y-m-d H:i:s', $startTime), 'requestType' => strtoupper($requestType), 'method' => $method, 'headers' => $headers, 'rawBody' => $rawRequest, 'body' => $data],
					'response' => ['time' => round(microtime(true) - $startTime, 2), 'status' => (method_exists($response, 'getStatusCode') ? $response->getStatusCode() : '-'), 'reasonPhrase' => (method_exists($response, 'getReasonPhrase') ? $response->getReasonPhrase() : '-'), 'error' => $e->__toString(), 'headers' => (method_exists($response, 'getHeaders') ? $response->getHeaders() : '-'), 'rawBody' => ($rawResponse ?? '')],
				], 'Api');
			}
			throw new Exceptions\AppException('An error occurred while communicating with the CRM', 500, $e);
		}
		if (\App\Config::$debugApi) {
			$_SESSION['debugApi'][] = [
				'date' => date('Y-m-d H:i:s', $startTime),
				'time' => round(microtime(true) - $startTime, 2),
				'method' => $method,
				'requestType' => strtoupper($requestType),
				'requestId' => RequestUtil::requestId(),
				'rawRequest' => [$headers, $rawRequest],
				'rawResponse' => $rawResponse,
				'response' => $responseBody,
				'trace' => Debug::getBacktrace(),
			];
		}
		if (Config::$apiAllLogs || (Config::$apiErrorLogs && (isset($responseBody['error']) || empty($responseBody) || 200 !== $response->getStatusCode()))) {
			\App\Log::info([
				'request' => ['date' => date('Y-m-d H:i:s', $startTime), 'requestType' => strtoupper($requestType), 'method' => $method, 'headers' => $headers, 'rawBody' => $rawRequest, 'body' => $data],
				'response' => ['time' => round(microtime(true) - $startTime, 2), 'status' => $response->getStatusCode(), 'reasonPhrase' => $response->getReasonPhrase(), 'headers' => $response->getHeaders(),	'rawBody' => $rawResponse, 'body' => $responseBody],
			], 'Api');
		}
		if (isset($responseBody['error'])) {
			$_SESSION['systemError'][] = $responseBody['error'];
			throw new Exceptions\AppException($responseBody['error']['message'], $responseBody['error']['code'] ?? 500);
		}
		if (empty($responseBody) || 200 !== $response->getStatusCode()) {
			throw new Exceptions\AppException("API returned an error:\n" . $response->getReasonPhrase(), $response->getStatusCode());
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
