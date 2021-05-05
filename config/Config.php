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
	public static $apiUrl = '__API_PATH__';

	/** @var string Portal URL. */
	public static $portalUrl = '__PORTAL_PATH__';

	/** @var string Web service - Application KEY. */
	public static $apiKey = '__API_KEY__';

	/** @var string Web service - Application login. */
	public static $serverName = '__SERVER_NAME__';

	/** @var string Web service - Application password. */
	public static $serverPass = '__SERVER_PASS__';

	/** @var string Header alert message */
	public static $headerAlertMessage = '11111111 222222222 3333333';

	/** @var string Header alert type, ex. alert-primary, alert-danger, alert-warning, alert-info */
	public static $headerAlertType = 'alert-primary';

	/** @var string Header alert icon, ex.  fas fa-exclamation-triangle, fas fa-exclamation-circle, fas fa-exclamation, far fa-question-circle, fas fa-info-circle */
	public static $headerAlertIcon = 'fas fa-exclamation-triangle';

	/** @var string Login page alert message */
	public static $loginPageAlertMessage = '11111111 222222222 3333333';

	/** @var string Login page alert type, ex. alert-primary, alert-danger, alert-warning, alert-info */
	public static $loginPageAlertType = 'alert-primary';

	/** @var string Login page alert icon, ex.  fas fa-exclamation-triangle, fas fa-exclamation-circle, fas fa-exclamation, far fa-question-circle, fas fa-info-circle */
	public static $loginPageAlertIcon = 'fas fa-info-circle';

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
	public static $allowLanguageSelection = true;

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
