<?php
/**
 * Config class.
 *
 * @package Config
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Conf;

/**
 * Config class.
 */
class Config
{
	/** @var string CRM API URL ex. https://gitdeveloper.yetiforce.com/webservice/. */
	public static $apiUrl = 'http://yeti/webservice/';

	/** @var string Portal URL. */
	public static $portalUrl = 'http://portal2/';

	/** @var string Web service - Application KEY. */
	public static $apiKey = 'VMUwRByXHSq1bLW485ikfvcC97P6gJsz';

	/** @var string Web service - Application login. */
	public static $serverName = 'portal';

	/** @var string Web service - Application password. */
	public static $serverPass = 'portal';

	/** @var string Additional message in the header */
	public static $headerMessage = '';

	/** @var string Default module. */
	public static $defaultModule = 'HelpDesk';

	/** @var string Default language. */
	public static $language = 'en-US';

	/** @var string[] Languages. */
	public static $languages = [
		'en-US' => 'English',
		'pl-PL' => 'Polski',
	];

	/** @var bool Allow the user to choose a language. */
	public static $allowLanguageSelection = false;

	/** @var string Theme. */
	public static $theme = 'Default';

	/**
	 * The number of items on the pageUndocumented variable.
	 *
	 * @var int
	 */
	public static $itemsPrePage = 12;

	/**
	 * Available record display options in listview for datatable element - [[values],[labels]].
	 *
	 * @var array
	 */
	public static $listEntriesPerPage = [[10, 25, 50, 100], [10, 25, 50, 100]];
	public static $minScripts = false;
	public static $debugApi = true;
	public static $debugConsole = true;
	public static $logs = false;
	public static $encryptDataTransfer = false;
	public static $privateKey = 'config/private.key';
	public static $publicKey = 'config/public.key';
	public static $logo = 'layouts/Default/skins/images/logo.png';
	public static $version = '1.0';
	public static $cachingDriver = 'Base';
	public static $defaultCharset = 'UTF-8';
	public static $csrfProtection = true;
	public static $displayDetailsException = true;

	/**
	 * Type of payment.
	 *
	 * @var string
	 */
	public static $paymentType = ['CashOnDelivery', 'Transfer'];
	public static $paymentServerName = '';
	public static $paymentServerPass = '';
	public static $paymentApiKey = '';
	public static $addDelivery = false;
	public static $filterInProducts = [];
	public static $subjectPrefixForSingleOrderFromCart = 'SSingleOrders - ';
}
