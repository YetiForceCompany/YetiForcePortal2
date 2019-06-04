<?php
/**
 * The file contains: TransactionState class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments\Utilities;

/**
 * Unified transaction status, common for all payments.
 */
class TransactionState
{
	/**
	 * Definition of payment statuses.
	 */
	const STATUS_NEW = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_COMPLETED = 3;
	const STATUS_REJECTED = 4;

	/**
	 * Order ID.
	 *
	 * @var string
	 */
	public $orderNumber;

	/**
	 * Transaction ID.
	 *
	 * @var string
	 */
	public $transactionId;

	/**
	 * Order ID associated with the transaction.
	 *
	 * @var int
	 */
	public $crmOrderId;

	/**
	 * Type of transaction.
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Transaction status.
	 *
	 * @var int
	 */
	public $status;

	/**
	 * User custom data container.
	 *
	 * @var mixed
	 */
	public $userData;

	/**
	 * Amount.
	 *
	 * @var float
	 */
	public $amount;

	/**
	 * Original amount.
	 *
	 * @var float
	 */
	public $originalAmount;

	/**
	 * Currency of the transaction.
	 *
	 * @var string
	 */
	public $currency;

	/**
	 * The original currency of the transaction.
	 *
	 * @var string
	 */
	public $originalCurrency;

	/**
	 * Date of change of status.
	 *
	 * @var \DateTime
	 */
	public $datetime;

	/**
	 * Description.
	 *
	 * @var string
	 */
	public $description;
}
