<?php
/**
 * The file contains: Description class.
 *
 * @package Config
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Conf\Payments;

/**
 * Class Description.
 */
class Redsys extends \App\AbstractConfig
{
	/**
	 * Private key.
	 *
	 * @var string
	 */
	protected $privateKey;

	/**
	 * Payment execution URL.
	 *
	 * @var string
	 */
	protected $paymentExecutionURL;

	/**
	 * Signature version.
	 *
	 * @var string
	 */
	protected $signatureVersion = 'HMAC_SHA256_V1';

	/**
	 * Ds_Merchant_MerchantCode - (Mandatory) The FUC code assigned to the seller.
	 *
	 * @var string
	 */
	protected $dsMerchantMerchantCode;

	/**
	 * Ds_Merchant_Terminal - (Mandatory) The number of the terminal that your bank assigned.
	 *
	 * @var string
	 */
	protected $dsMerchantTerminal;

	/**
	 * Ds_Merchant_TransactionType - (Mandatory) Type transaction.
	 *
	 * @var string
	 */
	protected $dsMerchantTransactionType;

	/**
	 * Ds_Merchant_MerchantURL - (Mandatory) Seller's URL for online notifications. Mandatory if the merchant has an "online" notification.
	 *
	 * @var string
	 */
	protected $dsMerchantMerchantURL = 'payments.php?paymentSystem=Redsys';

	/**
	 * Ds_Merchant_UrlOK - (Optional) If the process is successful, the user will be redirected to this address.
	 * Parameters "paymentSystem", "status" are required. Example &paymentSystem=Redsys&status=OK.
	 *
	 * @var string
	 */
	protected $dsMerchantUrlOK = 'index.php?module=Products&view=PaymentAfterPurchase&paymentSystem=Redsys&status=OK';

	/**
	 * Ds_Merchant_UrlKO - (Optional) If the process fails, the user will be redirected to this address.
	 * Parameters "paymentSystem", "status" are required. Example &paymentSystem=Redsys&status=ERROR.
	 *
	 * @var string
	 */
	protected $dsMerchantUrlKO = 'index.php?module=Products&view=PaymentAfterPurchase&paymentSystem=Redsys&status=ERROR';

	/**
	 * Merchant name - (Optional) Maximum length 25 characters.
	 *
	 * @var string
	 */
	protected $dsMerchantMerchantname = '';

	/**
	 * Order prefix - The first four characters must be a number. The remaining characters are [0-9a-zA-Z]. See the documentation Ds_Merchant_Order.
	 *
	 * @var string
	 */
	protected $orderPrefix = '0000';

	/**
	 * The HTTP method that data will be sent to the payment system.
	 *
	 * @var string
	 */
	protected $typeOfOutputCommunication = 'POST';
}
