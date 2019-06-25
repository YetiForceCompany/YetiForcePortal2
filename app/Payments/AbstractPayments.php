<?php
/**
 * The file contains: AbstractPayments class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * The class includes common things for different payment systems.
 */
abstract class AbstractPayments
{
	/**
	 * Allowed parameters.
	 */
	const ALLOWED_PARAMETERS = [];

	/**
	 * Allowed parameters coming from the payment system.
	 */
	const ALLOWED_PARAMETERS_FROM_PAYMENT_SYSTEM = [];

	/**
	 * Available statuses from the payment system.
	 */
	const AVAILABLE_STATUSES = [];

	const PARAMETER_FROM_CONFIG = [];

	/**
	 * Parameters.
	 *
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * Configuration.
	 *
	 * @var ConfigInterface
	 */
	protected $config;

	/**
	 * Type of payments.
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Validation of incoming data from the payment system.
	 *
	 * @param array $requestParameters
	 *
	 * @return bool
	 */
	public function validateRequestFromPaymentsSystem(array $requestParameters): bool
	{
		return false;
	}

	/**
	 * Returns type of payments.
	 *
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * Returns payment's icon.
	 *
	 * @return string
	 */
	public function getIcon(): string
	{
		return $this->icon;
	}

	/**
	 * Set parameter.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return self
	 */
	public function setParameter(string $key, $value): self
	{
		if (!\in_array($key, static::ALLOWED_PARAMETERS)) {
			throw new \App\Exception\Payments('Not allowed parameter');
		}
		$this->parameters[$key] = $value;
		return $this;
	}

	/**
	 * Gets parameter.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function getParameter(string $key)
	{
		if (!\in_array($key, static::ALLOWED_PARAMETERS)) {
			throw new \App\Exception\Payments('Not allowed parameter');
		}
		return $this->parameters[$key] ?? null;
	}

	/**
	 * Get parameters.
	 *
	 * @return array
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

	/**
	 * Build an HTTP query from parameters.
	 *
	 * @return string
	 */
	public function getHttpQuery(): string
	{
		return http_build_query($this->getParameters());
	}

	protected function setParameterFromConfig()
	{
		foreach (static::PARAMETER_FROM_CONFIG as $parameterName => $configName) {
			$this->setParameter($parameterName, $this->config->get($configName));
		}
	}

	/**
	 * Get absolute URL for Portal2.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	protected function AbsoluteUrl(string $url): string
	{
		return \App\Config::get('portalUrl') . $url;
	}
}
