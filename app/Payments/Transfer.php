<?php
/**
 * The file contains: Description class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Payments;

/**
 * Class Description.
 */
class Transfer extends AbstractPayments implements PaymentsInterface
{
	const ALLOWED_PARAMETERS = ['orderId'];

	/**
	 * {@inheritdoc}
	 */
	public function __construct(ConfigInterface $config, string $type)
	{
		$this->config = $config;
		$this->type = $type;
		$this->setParameterFromConfig();
	}

	/**
	 * Returns url after order.
	 */
	public function getUrlReturn()
	{
		return $this->config->get('urlReturn') . '&crmOrderId=' . $this->getParameter('orderId');
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCrmOrderId(int $crmId)
	{
		$this->setParameter('orderId', $crmId);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPicklistValue(): string
	{
		return 'PLL_TRANSFER';
	}
}
