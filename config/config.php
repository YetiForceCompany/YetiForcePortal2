<?php
/**
 * Main configuration file
 */
defined('_EXEC') or die;

$config = [];
$config['crmPath'] = 'http://localhost/crm/';
$config['portalPath'] = 'http://localhost/portal/';
$config['language'] = 'pl_pl';
$config['theme'] = 'default';
$config['defaultModule'] = 'HelpDesk';
$config['timezone'] = 'Europe/Warsaw';
$config['languages'] = [
	'en_us' => 'English',
	'pl_pl' => 'Polski',
];
$config['listMaxEntriesFromApi'] = 50;
// Available record display options in listview for datatable element - [[values],[labels]]
$config['listEntriesPerPage'] = [[10, 25, 50, 100], [10, 25, 50, 100]];
$config['minScripts'] = false;
$config['debugApi'] = false;
$config['logs'] = false;
// Security
$config['apiKey'] = '5O3lbM2EQhHAZY9nTupkwz7gqJRLGsme';
$config['serverName'] = 'portal';
$config['serverPass'] = 'portal';
$config['encryptDataTransfer'] = false;
$config['privateKey'] = 'config/private.key';
$config['publicKey'] = 'config/public.key';
$config['logo'] = 'layouts/Default/skins/images/logo.png';
/** If timezone is configured, try to set it */
if (isset($config['timezone']) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($config['timezone']);
}
