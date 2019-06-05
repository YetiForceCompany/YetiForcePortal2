<?php
/**
 * The file contains: Interface for multi-currency payments.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * Interface for multi-currency payments.
 */
interface PaymentsMultiCurrencyInterface
{
	/**
	 * Set the currency for the transaction.
	 *
	 * @param string $currency
	 *
	 * @return void
	 */
	public function setCurrency(string $currency);
}
