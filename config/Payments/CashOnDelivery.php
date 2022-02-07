<?php
/**
 * The file contains: Description class.
 *
 * @package Config
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Conf\Payments;

/**
 * Class Description.
 */
class CashOnDelivery extends \App\AbstractConfig
{
	protected $urlReturn = 'index.php?module=Products&view=PaymentAfterPurchase&paymentSystem=CashOnDelivery';
}
