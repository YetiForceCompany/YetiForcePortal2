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
interface PaymentsSystemInterface extends PaymentsInterface
{
	/**
	 * Return the URL for the transaction.
	 *
	 * @return string
	 */
	public function getPaymentExecutionURL(): string;

	/**
	 * Generate a payment URL for the GET method.
	 *
	 * @return string
	 */
	public function generatePaymentURL(): string;

	/**
	 * Return parameters for the form / POST. $name -> $value.
	 *
	 * @return array
	 */
	public function getParametersForForm(): array;

	/**
	 * The type of communication for data sent to the payment system.
	 *
	 * @return string
	 */
	public function getTypeOfOutputCommunication(): string;

	/**
	 * Handle the request from the payment system.
	 *
	 * @param array $dataFromRequest
	 *
	 * @return Utilities\TransactionState
	 */
	public function requestHandlingFromPaymentsSystem(array $dataFromRequest): Utilities\TransactionState;

	/**
	 * Answer for the payment system, if everything is ok.
	 *
	 * @return string
	 */
	public function successAnswerForPaymentSystem(): string;

	/**
	 * Set the amount for the transaction.
	 *
	 * @param float $amount
	 *
	 * @return void
	 */
	public function setAmount(float $amount);

	/**
	 * Set description.
	 *
	 * @param string $description
	 *
	 * @return void
	 */
	public function setDescription(string $description);

	/**
	 * Handling return - When the user returns to the portal from the payment system.
	 *
	 * @param array $dataFromRequest
	 *
	 * @return void
	 */
	public function handlingReturn(array $dataFromRequest);
}
