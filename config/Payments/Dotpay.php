<?php
/**
 * The file contains: Description class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace Conf\Payments;

/**
 * Class Description.
 */
class Dotpay extends \App\AbstractConfig
{
	/**
	 * Payment execution URL.
	 *
	 * @var string
	 */
	protected $paymentExecutionURL;

	/**
	 * Merchant's store ID in the Dotpay system.
	 *
	 * @var int
	 */
	protected $id;

	/**
	 * Dotpay pin - this is the private key.
	 *
	 * @var string
	 */
	protected $dotpayPin;

	/**
	 * Internet address (HTTP or HTTPS) for which to return buyer after payment.
	 * Parameters "paymentSystem", "status" are required. Example &paymentSystem=Redsys&status=ERROR.
	 *
	 * @var string
	 */
	protected $urlReturn;

	/**
	 * The HTTP method that data will be sent to the payment system.
	 *
	 * @var string
	 */
	protected $typeOfOutputCommunication = 'POST';
}
