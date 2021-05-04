<?php
/**
 * The file contains: Dotpay payments class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * Class Dotpay payments.
 */
class Dotpay extends AbstractPayments implements PaymentsSystemInterface, PaymentsMultiCurrencyInterface
{
	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	const ALLOWED_PARAMETERS = [
		'api_version',
		//'charset',
		'lang',
		'id',
		'pid',
		'amount',
		'currency',
		'description',
		'control',
		'channel',
		'credit_card_brand',
		'ch_lock',
		'channel_groups',
		'onlinetransfer',
		'url',
		'type',
		'buttontext',
		'urlc',
		'firstname',
		'lastname',
		'email',
		'street',
		'street_n1',
		'street_n2',
		'state',
		'addr3',
		'city',
		'postcode',
		'phone',
		'country',
		'code',
		'p_info',
		'p_email',
		'n_email',
		'expiration_date',
		'deladdr',
		'recipient_account_number',
		'recipient_company',
		'recipient_first_name',
		'recipient_last_name',
		'recipient_address_street',
		'recipient_address_building',
		'recipient_address_apartment',
		'recipient_address_postcode',
		'recipient_address_city',
		'application',
		'application_version',
		'warranty',
		'bylaw',
		'personal_data',
		'credit_card_number',
		'credit_card_expiration_date_year',
		'credit_card_expiration_date_month',
		'credit_card_security_code',
		'credit_card_store',
		'credit_card_store_security_code',
		'credit_card_customer_id',
		'credit_card_id',
		'blik_code',
		'credit_card_registration',
		'surcharge_amount',
		'surcharge',
		'surcharge',
		'ignore_last_payment_channel',
		'vco_call_id',
		'vco_update_order_info',
		'vco_subtotal',
		'vco_shipping_handling',
		'vco_tax',
		'vco_discount',
		'vco_gift_wrap',
		'vco_misc',
		'vco_promo_code',
		'credit_card_security_code_required',
		'credit_card_operation_type',
		'credit_card_avs',
		'credit_card_threeds',
		'customer',
		'gp_token',
	];

	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	const ALLOWED_PARAMETERS_FROM_PAYMENT_SYSTEM = [
		'id',
		'operation_number',
		'operation_type',
		'operation_status',
		'operation_amount',
		'operation_currency',
		'operation_withdrawal_amount',
		'operation_commission_amount',
		'is_completed',
		'operation_original_amount',
		'operation_original_currency',
		'operation_datetime',
		'operation_related_number',
		'control',
		'description',
		'email',
		'p_info',
		'p_email',
		'credit_card_issuer_identification_number',
		'credit_card_masked_number',
		'credit_card_expiration_year',
		'credit_card_expiration_month',
		'credit_card_brand_codename',
		'credit_card_brand_code',
		'credit_card_unique_identifier',
		'credit_card_id',
		'channel',
		'channel_country',
		'geoip_country',
		'signature',
	];

	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	const AVAILABLE_STATUSES = [
		'completed' => Utilities\TransactionState::STATUS_COMPLETED,
		'rejected' => Utilities\TransactionState::STATUS_REJECTED,
		'new' => Utilities\TransactionState::STATUS_NEW,
		'processing' => Utilities\TransactionState::STATUS_PROCESSING,
	];

	/**
	 * Dotpay pin - this is the private key.
	 *
	 * @var string
	 */
	private $dotpayPin;

	private $multiMerchantList = [];

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function __construct(ConfigInterface $config, string $type)
	{
		$this->config = $config;
		$this->type = $type;
		$this->icon = 'fas fa-hand-holding-usd';
		$this->setDotpayPin($config->get('dotpayPin'))
			->setParameter('lang', 'en')
			->setParameter('id', $config->get('id'));
	}

	/** {@inheritdoc} */
	public function getPicklistValue(): string
	{
		return 'PLL_DOTPAY';
	}

	/**
	 * PaymentsMultiCurrencyInterface
	 * {@inheritdoc}
	 */
	public function setCurrency(string $currency)
	{
		$this->setParameter('currency', $currency);
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function setAmount(float $amount)
	{
		$this->setParameter('amount', $amount);
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
		return $this->getPaymentExecutionURL() . '?' . $this->getHttpQuery();
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function getParametersForForm(): array
	{
		return $this->getParameters();
	}

	/**
	 * PaymentsInterface
	 * {@inheritdoc}
	 */
	public function requestHandlingFromPaymentsSystem(array $dataFromRequest): Utilities\TransactionState
	{
		if (!$this->validateRequestFromPaymentsSystem($dataFromRequest)) {
			throw new \App\Exception\Payments('Signature error, incorrect data');
		}
		$transactionState = new Utilities\TransactionState();
		$transactionState->amount = (float) $dataFromRequest['operation_amount'];
		$transactionState->originalAmount = (float) $dataFromRequest['operation_original_amount'];
		$transactionState->datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $dataFromRequest['operation_datetime']);
		if (false === $transactionState->datetime) {
			throw new \App\Exception\Payments('Invalid date format');
		}
		$transactionState->currency = $dataFromRequest['operation_currency'];
		$transactionState->originalCurrency = $dataFromRequest['operation_original_currency'];
		$transactionState->crmOrderId = (int) $dataFromRequest['control'];
		$transactionState->description = $dataFromRequest['description'];
		if (empty(static::AVAILABLE_STATUSES[$dataFromRequest['operation_status']])) {
			throw new \App\Exception\Payments('Unknown status');
		}
		$transactionState->status = static::AVAILABLE_STATUSES[$dataFromRequest['operation_status']];
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
	public function setCrmOrderId(int $crmId)
	{
		$this->setParameter('control', $crmId);
		if (!$this->config->isEmpty('urlReturn')) {
			$this->setParameter('type', 0)
				->setParameter('buttontext', 'RETURN')
				->setParameter('url', $this->config->get('urlReturn') . '&crmOrderId=' . $crmId);
		}
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
	public function setDescription(string $description)
	{
		$this->setParameter('description', $description);
	}

	/**
	 * Set Dotpay pin.
	 *
	 * @param string $dotpayPin
	 *
	 * @return self
	 */
	public function setDotpayPin(string $dotpayPin): self
	{
		$this->dotpayPin = $dotpayPin;
		return $this;
	}

	/**
	 * AbstractPayments
	 * {@inheritdoc}
	 */
	public function getParameters(): array
	{
		return $this->parameters + ['chk' => $this->calculateSignature()];
	}

	/**
	 * Calculate the checksum, signature..
	 *
	 * @return string
	 */
	public function calculateSignature(): string
	{
		return hash('sha256', $this->joinParameters());
	}

	/**
	 * Calculate the checksum, signature from incoming data from the payment system.
	 *
	 * @param array $requestFromDotpay
	 *
	 * @return string
	 */
	public function calculateSignatureFromDotpay(array $requestFromDotpay): string
	{
		$signature = $this->dotpayPin;
		foreach ($requestFromDotpay as $key => $value) {
			if ('signature' !== $key && \in_array($key, static::ALLOWED_PARAMETERS_FROM_PAYMENT_SYSTEM)) {
				$signature .= $value;
			}
		}
		return hash('sha256', $signature);
	}

	public function validateRequestFromPaymentsSystem(array $requestParameters): bool
	{
		return $this->calculateSignatureFromDotpay($requestParameters) === $requestParameters['signature'];
	}

	private function joinParameters(): string
	{
		$signature = $this->dotpayPin;
		foreach (static::ALLOWED_PARAMETERS as $parameter) {
			$signature .= $this->parameters[$parameter] ?? null;
		}
		foreach ($this->multiMerchantList as $item) {
			foreach ($item as $value) {
				$signature .= ($value ?? null);
			}
		}
		return $signature;
	}
}
