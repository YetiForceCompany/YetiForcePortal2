<?php
/**
 * The file contains: Description class.
 *
 * @package Config
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Conf\Payments;

/**
 * Class Description.
 */
class Transfer extends \App\AbstractConfig
{
	protected $urlReturn = 'index.php?module=Products&view=PaymentAfterPurchase&paymentSystem=CashOnDelivery';
	/**
	 * Bank account owner - this is the bank account owner.
	 *
	 * @var string
	 */
	protected $bankAccountOwner;
	/**
	 * Bank account address - this is the bank account address.
	 *
	 * @var string
	 */
	protected $bankAccountAddress;
	/**
	 * Bank account number - this is the bank account number.
	 *
	 * @var int
	 */
	protected $bankAccountNumber;
}
