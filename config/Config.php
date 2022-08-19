<?php
/**
 * Config class.
 *
 * @package Config
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace Conf;

/**
 * Config class.
 */
class Config
{
	/** @var string portal version. */
	public static $version = '6.4';

	/** @var string Portal name. */
	public static $siteName = '';

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

	/** @var string The path to the logo on the login page */
	public static $logoLoginPage = 'layouts/logo_login.png';

	/** @var string The path to the logo in menu */
	public static $logoMenu = 'layouts/logo_menu.png';

	/** @var string Default module. */
	public static $defaultModule = 'HelpDesk';

	/** @var string Default language, ex. en-US , pl-PL */
	public static $language = 'en-US';

	/** @var bool Allow the user to choose a language. */
	public static $allowLanguageSelection = true;

	/** @var string Theme. */
	public static $theme = 'Default';

	/**  The number of items on the page. */
	public static $itemsPrePage = 12;

	/** @var array Available record display options in listview for datatable element - [[values],[labels]]. */
	public static $listEntriesPerPage = [[10, 25, 50, 100], [10, 25, 50, 100]];

	/**
	 * Debugging.
	 */

	/** @var bool Enable minimize JS files. */
	public static $minScripts = false;

	/** @var bool Enable api debug. */
	public static $debugApi = false;

	/** @var bool Display main debug console. */
	public static $debugConsole = false;

	/** @var bool Show detailed information about error exceptions */
	public static $displayDetailsException = false;

	/** @var bool Show path tracking for error exceptions. */
	public static $displayTrackingException = false;

	/** @var bool Enable saving all API logs to file. */
	public static $apiAllLogs = false;

	/** @var bool Enable saving error API logs to file. */
	public static $apiErrorLogs = false;

	/**
	 * Security.
	 */

	/** @var bool Webservice config. */
	public static $encryptDataTransfer = false;

	/** @var bool Webservice config. */
	public static $privateKey = 'config/private.key';

	/** @var bool Webservice config. */
	public static $publicKey = 'config/public.key';

	/** @var bool Enable CSRF protection. */
	public static $csrfProtection = true;

	/** @var bool Check whether brute force is enabled */
	public static $bruteForceIsEnabled = false;

	/** @var bool Daily limit of failed login attempts. */
	public static $bruteForceDayLimit = 100;

	/** @var string[] Trusted IPs, are not verified by brute force */
	public static $bruteForceTrustedIp = [];

	/** @var string Session name */
	public static $sessionName = '';

	/** @var bool Force the use of https only for cookie. Values: true, false, null */
	public static $cookieForceHttpOnly = true;

	/** @var string Same-site cookie attribute allows a web application to advise the browser that cookies should only be sent if the request originates from the website the cookie came from. Values: None, Lax, Strict. */
	public static $cookieSameSite = 'Strict';

	/** @var bool HTTP Content Security Policy response header allows website administrators to control resources the user agent is allowed to load for a given page */
	public static $cspHeaderActive = true;

	/** @var string[] HTTP Public-Key-Pins (HPKP) pin-sha256 For HPKP to work properly at least 2 keys are needed.\nhttps://scotthelme.co.uk/hpkp-http-public-key-pinning/, https://sekurak.pl/mechanizm-http-public-key-pinning/. */
	public static $hpkpKeysHeader = [];

	/**
	 * Performance.
	 */

	/** @var string Data caching is about storing some PHP variables in cache and retrieving it later from cache. Drivers: Base, Apcu. */
	public static $cachingDriver = 'Base';

	/** @var string Default charset: default value = "UTF-8". */
	public static $defaultCharset = 'UTF-8';

	/** Number of items displayed in picklists. */
	public static $picklistLimit = 50;

	/** Maximum character length in list view. */
	public static $listViewItemMaxLength = 30;

	/**
	 * Alert messages.
	 */

	/** @var string Header alert message */
	public static $headerAlertMessage = '';

	/** @var string Header alert type, ex. alert-primary, alert-danger, alert-warning, alert-info */
	public static $headerAlertType = 'alert-primary';

	/** @var string Header alert icon, ex.  fas fa-exclamation-triangle, fas fa-exclamation-circle, fas fa-exclamation, far fa-question-circle, fas fa-info-circle */
	public static $headerAlertIcon = 'fas fa-exclamation-triangle';

	/** @var string Login page alert message */
	public static $loginPageAlertMessage = '';

	/** @var string Login page alert type, ex. alert-primary, alert-danger, alert-warning, alert-info */
	public static $loginPageAlertType = 'alert-primary';

	/** @var string Login page alert icon, ex.  fas fa-exclamation-triangle, fas fa-exclamation-circle, fas fa-exclamation, far fa-question-circle, fas fa-info-circle */
	public static $loginPageAlertIcon = 'fas fa-info-circle';

	/**
	 * Payments.
	 */

	/** @var string[] Type of payment. */
	public static $paymentType = ['CashOnDelivery', 'Transfer'];

	/** @var string Name of the payment server. */
	public static $paymentServerName = '';

	/** @var string Payment server password. */
	public static $paymentServerPass = '';

	/** @var string Api key for payment server. */
	public static $paymentApiKey = '';

	/**
	 * Store functionality.
	 */

	/** @var string Add Delivery. */
	public static $addDelivery = false;

	/** @var string[] Set filtering by field names in products. */
	public static $filterInProducts = [];

	/** @var string Subject prefix for a single order from the cart. */
	public static $subjectPrefixForSingleOrderFromCart = 'SSingleOrders - ';

	/**
	 * Additional configuration of API connection.
	 */

	/** @var array The default configuration of GuzzleHttp. */
	public static $options = [
		'timeout' => 10,
		'connect_timeout' => 2,
		// 'verify' => false,
	];

	/**
	 * User preferences and config.
	 */

	/** @var array Default user preferences */
	public static $userPreferences = [
		'menuPin' => 0
	];
}
