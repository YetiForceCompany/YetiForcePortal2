<?php
/**
 * The file contains: Factory to create objects payment.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Factory to create objects payment.
 */
class Payments
{
	/**
	 * Get instance of payments.
	 *
	 * @param string $typeOfPayments
	 *
	 * @return Payments\PaymentsInterface
	 */
	public static function getInstance(string $typeOfPayments): Payments\PaymentsInterface
	{
		$classConfig = "\\Conf\\Payments\\{$typeOfPayments}";
		if (!\class_exists($classConfig)) {
			throw new \App\Exceptions\Payments("There is no configuration file for this type of payment: {$typeOfPayments}");
		}
		$classPayment = "\\App\\Payments\\{$typeOfPayments}";
		if (!\class_exists($classPayment)) {
			throw new \App\Exceptions\Payments("Unknown payment type: {$typeOfPayments}");
		}
		return new $classPayment(new $classConfig(), $typeOfPayments);
	}
}
