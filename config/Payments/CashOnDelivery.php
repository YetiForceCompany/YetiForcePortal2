<?php
/**
 * The file contains: Description class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */

namespace Conf\Payments;

/**
 * Class Description.
 */
class CashOnDelivery extends \App\AbstractConfig
{
	protected $urlReturn = 'index.php?module=Products&view=PaymentAfterPurchase&paymentSystem=CashOnDelivery';
}
