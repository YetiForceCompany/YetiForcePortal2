<?php
/**
 * Config class.
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
	/**
	 * Crm URL.
	 *
	 * @var string
	 */
	public static $crmUrl = 'http://yeti/';

	/**
	 * Portal URL.
	 *
	 * @var string
	 */
	public static $portalUrl = 'http://portal2/';

	/**
	 * Theme.
	 *
	 * @var string
	 */
	public static $theme = 'Default';

	/**
	 * Default module.
	 *
	 * @var string
	 */
	public static $defaultModule = 'HelpDesk';

	/**
	 * Default language.
	 *
	 * @var string
	 */
	public static $language = 'en-US';

	/**
	 * Languages.
	 *
	 * @var array
	 */
	public static $languages = [
		'en-US' => 'English',
		'pl-PL' => 'Polski',
	];

	/**
	 * Allow the user to choose a language.
	 *
	 * @var bool
	 */
	public static $allowLanguageSelection = false;

	/**
	 * Available record display options in listview for datatable element - [[values],[labels]].
	 *
	 * @var array
	 */
	public static $listEntriesPerPage = [[10, 25, 50, 100], [10, 25, 50, 100]];
	public static $minScripts = false;
	public static $debugApi = false;
	public static $debugConsole = false;
	public static $logs = false;
	public static $apiKey = 'VMUwRByXHSq1bLW485ikfvcC97P6gJsz';
	public static $serverName = 'portal';
	public static $serverPass = 'portal';
	public static $encryptDataTransfer = false;
	public static $privateKey = 'config/private.key';
	public static $publicKey = 'config/public.key';
	public static $logo = 'layouts/Default/skins/images/logo.png';
	public static $version = '1.0';
	public static $cachingDriver = 'Base';
	public static $defaultCharset = 'UTF-8';
}
