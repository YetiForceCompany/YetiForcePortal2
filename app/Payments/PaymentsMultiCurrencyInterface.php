<?php
/**
 * The file contains: Interface for multi-currency payments.
 *
 * @package App
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
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
