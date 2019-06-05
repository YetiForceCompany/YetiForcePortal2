<?php
/**
 * The file contains: Description class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * Class Description.
 */
class Redsys extends AbstractPayments implements PaymentsInterface, PaymentsMultiCurrencyInterface
{
	/**
	 * Allowed parameters in the form / POST. The process of sending data to the payment system.
	 */
	const ALLOWED_PARAMETERS = [
		'DS_MERCHANT_MERCHANTCODE',
		'DS_MERCHANT_TERMINAL',
		'DS_MERCHANT_TRANSACTIONTYPE',
		'DS_MERCHANT_AMOUNT',
		'DS_MERCHANT_CURRENCY',
		'DS_MERCHANT_ORDER',
		'DS_MERCHANT_MERCHANTURL',
		'DS_MERCHANT_PRODUCTDESCRIPTION',
		'DS_MERCHANT_TITULAR',
		'DS_MERCHANT_URLOK',
		'DS_MERCHANT_URLKO',
		'DS_MERCHANT_MERCHANTNAME',
		'DS_MERCHANT_CONSUMERLANGUAGE',
		'DS_MERCHANT_SUMTOTAL',
		'DS_MERCHANT_MERCHANTDATA',
		'DS_MERCHANT_DATEFRECUENCY',
		'DS_MERCHANT_CHARGEEXPIRYDATE',
		'DS_MERCHANT_AUTHORISATIONCODE',
		'DS_MERCHANT_TRANSACTIONDATE',
		'DS_MERCHANT_IDENTIFIER',
		'DS_MERCHANT_GROUP',
		'DS_MERCHANT_DIRECTPAYMENT',
		'DS_MERCHANT_PAN',
		'DS_MERCHANT_EXPIRYDATE',
		'DS_MERCHANT_CVV2',
	];

	/**
	 * List of parameters set from configuration in the constructor.
	 */
	const PARAMETER_FROM_CONFIG = [
		'DS_MERCHANT_MERCHANTCODE' => 'dsMerchantMerchantCode',
		'DS_MERCHANT_TERMINAL' => 'dsMerchantTerminal',
		'DS_MERCHANT_TRANSACTIONTYPE' => 'dsMerchantTransactionType',
		'DS_MERCHANT_MERCHANTURL' => 'dsMerchantMerchantURL',
	];

	/**
	 * Private key.
	 *
	 * @var string
	 */
	private $privateKey;

	/**
	 * Custom merchant data.
	 *
	 * @var array
	 */
	private $merchantData = [];

	/**
	 * {@inheritdoc}
	 */
	public function __construct(ConfigInterface $config)
	{
		$this->config = $config;
		$this->setPrivateKey($config->get('privateKey'));
		$this->setParameterFromConfig();
	}

	/**
	 * Set the order ID, required field.
	 *
	 * @param string $order
	 *
	 * @return void
	 */
	public function setOrder(string $order)
	{
		if (!\preg_match('/^[0-9]{4}[a-zA-Z0-9]{0,8}$/i', $order)) {
			throw new \App\Exception\Payments('Invalid order ID format');
		}
		$this->setParameter('DS_MERCHANT_ORDER', $order);
	}

	/**
	 * PaymentsMultiCurrencyInterface
	 * {@inheritdoc}
	 */
	public function setCurrency(string $currency)
	{
		$this->setParameter('DS_MERCHANT_CURRENCY', Utilities\CurrencyISO4217::getInfoFromSymbol($currency)['code']);
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function setAmount(float $amount)
	{
		$this->setParameter('DS_MERCHANT_AMOUNT', (int) ($amount * 100));
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function getPaymentExecutionURL(): string
	{
		return $this->config->get('paymentExecutionURL');
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function generatePaymentURL(): string
	{
		return $this->config->get('paymentExecutionURL') . '?' . http_build_query($this->getParametersForForm());
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function requestHandlingFromPaymentsSystem(array $dataFromRequest): Utilities\TransactionState
	{
		$dataFromRequest = array_change_key_case($dataFromRequest, \CASE_UPPER);
		if (!$this->validateRequestFromPaymentsSystem($dataFromRequest)) {
			throw new \App\Exception\Payments('Signature error, incorrect data');
		}
		$data = $this->decodeMerchantParameters($dataFromRequest['DS_MERCHANTPARAMETERS']);
		$currencyInfo = Utilities\CurrencyISO4217::getInfoFromCode($data['DS_CURRENCY']);
		if (empty($currencyInfo)) {
			throw new \App\Exception\Payments('Unknown currency');
		}
		$merchantDataParameters = \App\Json::decode($data['DS_MERCHANTDATA']);
		$transactionState = new Utilities\TransactionState();
		$transactionState->originalAmount = $transactionState->amount =
			round((float) $data['DS_AMOUNT'] / pow(10, $currencyInfo['numberOfDigitsAfter']), $currencyInfo['numberOfDigitsAfter']);
		$transactionState->transactionId = $transactionState->orderNumber = $data['DS_ORDER'];
		$transactionState->datetime = \DateTime::createFromFormat('d/m/Y H:i', $data['DS_DATE'] . $data['DS_HOUR']);
		$transactionState->crmOrderId = (int) $merchantDataParameters['crmId'];
		$transactionState->status = Utilities\TransactionState::STATUS_NEW;
		$transactionState->description = $merchantDataParameters['description'];
		if (false === $transactionState->datetime) {
			throw new \App\Exception\Payments('Invalid date format');
		}
		$transactionState->originalCurrency = $transactionState->currency = $currencyInfo['symbol'];
		return $transactionState;
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function handlingReturn(array $dataFromRequest)
	{
		if (empty($dataFromRequest['status']) || !\in_array($dataFromRequest['status'], ['OK', 'ERROR'])) {
			throw new \App\Exception\Payments('Invalid status');
		}
		$dataFromRequestCaseUpper = array_change_key_case($dataFromRequest, \CASE_UPPER);
		if (!$this->validateRequestFromPaymentsSystem($dataFromRequestCaseUpper)) {
			throw new \App\Exception\Payments('Signature error, incorrect data');
		}
		return [
			'crmOrderId' => empty($dataFromRequest['crmOrderId']) ? null : (int) $dataFromRequest['crmOrderId'],
			'status' => $dataFromRequest['status'],
		];
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function successAnswerForPaymentSystem(): string
	{
		return 'OK';
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function getTypeOfOutputCommunication(): string
	{
		return $this->config->get('typeOfOutputCommunication');
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function setCrmOrderId(int $crmId)
	{
		$this->setMerchantData('crmId', $crmId);
		$this->setOrder("0001CRM{$crmId}");
		$this->setParameter('DS_MERCHANT_URLOK', $this->config->get('dsMerchantUrlOK') . '&crmOrderId=' . $crmId);
		$this->setParameter('DS_MERCHANT_URLKO', $this->config->get('dsMerchantUrlKO') . '&crmOrderId=' . $crmId);
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function setDescription(string $description)
	{
		$this->setParameter('DS_MERCHANT_PRODUCTDESCRIPTION', $description);
		$this->setMerchantData('description', $description);
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function getParametersForForm(): array
	{
		return [
			'Ds_SignatureVersion' => $this->config->get('signatureVersion'),
			'Ds_MerchantParameters' => $this->createMerchantParameters(),
			'Ds_Signature' => $this->createMerchantSignature(),
		];
	}

	/**
	 * Set private key.
	 *
	 * @param string $privateKey
	 *
	 * @return self
	 */
	public function setPrivateKey(string $privateKey): self
	{
		$this->privateKey = $privateKey;
		return $this;
	}

	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	public function setParameter(string $key, $value): AbstractPayments
	{
		return parent::setParameter(\strtoupper($key), $value);
	}

	/**
	 * Create merchant parameters.
	 *
	 * @return string
	 */
	public function createMerchantParameters(): string
	{
		$this->setParameter('DS_MERCHANT_MERCHANTDATA', \App\Json::encode($this->merchantData));
		return \base64_encode(\json_encode($this->parameters));
	}

	public function createMerchantSignature(): string
	{
		if (empty($this->parameters['DS_MERCHANT_ORDER'])) {
			throw new \App\Exception\Payments('No parameter DS_MERCHANT_ORDER');
		}
		return \base64_encode($this->calculateSha256(
			$this->createMerchantParameters(),
			$this->encrypt3Des($this->parameters['DS_MERCHANT_ORDER'], \base64_decode($this->privateKey))
		));
	}

	public function createMerchantSignatureFromParameters(string $merchantParameters): string
	{
		$data = $this->decodeMerchantParameters($merchantParameters);
		if (empty($data['DS_ORDER'])) {
			throw new \App\Exception\Payments("No parameter 'DS_ORDER'");
		}
		return $this->base64UrlEncode($this->calculateSha256(
			$merchantParameters,
			$this->encrypt3Des($data['DS_ORDER'], \base64_decode($this->privateKey))
		));
	}

	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	public function validateRequestFromPaymentsSystem(array $requestParameters): bool
	{
		return (!empty($requestParameters['DS_SIGNATUREVERSION']) && 'HMAC_SHA256_V1' === $requestParameters['DS_SIGNATUREVERSION']) &&
			$this->createMerchantSignatureFromParameters($requestParameters['DS_MERCHANTPARAMETERS']) === $requestParameters['DS_SIGNATURE'];
	}

	/**
	 * Encrypt the message using the key with the 3DES algorithm.
	 *
	 * @param string $message
	 * @param string $key
	 *
	 * @return string
	 */
	private function encrypt3Des(string $message, string $key): string
	{
		$lengthMessage = \strlen($message);
		$lengthCeil = ceil($lengthMessage / 8) * 8;
		return substr(
			openssl_encrypt(
				$message . str_repeat("\0", $lengthCeil - $lengthMessage),
				'des-ede3-cbc',
				$key,
				OPENSSL_RAW_DATA,
				"\0\0\0\0\0\0\0\0"
			),
			0,
			$lengthCeil
		);
	}

	/**
	 * Decode merchant parameters.
	 *
	 * @param string $merchantParameters
	 *
	 * @return array
	 */
	private function decodeMerchantParameters(string $merchantParameters): array
	{
		$decodeParameters = $this->base64UrlDecode($merchantParameters);
		if (empty($decodeParameters)) {
			throw new \App\Exception\Payments('Problem with decode merchant parameters.');
		}
		$parameters = array_change_key_case(
			json_decode($decodeParameters, true),
			\CASE_UPPER
		);
		foreach ($parameters as &$value) {
			$value = \urldecode($value);
		}
		return $parameters;
	}

	private function base64UrlEncode(string $input): string
	{
		return strtr(base64_encode($input), '+/', '-_');
	}

	private function base64UrlDecode(string $input): string
	{
		return base64_decode(strtr($input, '-_', '+/'));
	}

	/**
	 * Calculate the checksum using the SHA256 algorithm.
	 *
	 * @param string $data
	 * @param string $key
	 *
	 * @return string
	 */
	private function calculateSha256(string $data, string $key): string
	{
		return hash_hmac('sha256', $data, $key, true);
	}

	/**
	 * Set merchant data.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	private function setMerchantData(string $key, $value)
	{
		$this->merchantData[$key] = $value;
	}
}
