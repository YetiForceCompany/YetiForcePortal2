<?php
/**
 * The file contains: Common interface for various payment systems.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * Common interface for various payment systems.
 */
interface PaymentsInterface
{
	/**
	 * Construct.
	 *
	 * @param ConfigInterface $config
	 * @param string          $type
	 */
	public function __construct(ConfigInterface $config, string $type);

	/**
	 * Set crm order ID.
	 *
	 * @param int $crmId
	 *
	 * @return void
	 */
	public function setCrmOrderId(int $crmId);

	/**
	 * Returns method payment for CRM.
	 *
	 * @return string
	 */
	public function getPicklistValue(): string;
}
