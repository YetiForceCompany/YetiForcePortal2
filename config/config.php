<?php
/**
 * Main configuration file
 */
defined('_EXEC') or die;

$config = [];
$config['crmPath'] = 'http://yeti/';
$config['language'] = 'pl_pl';
$config['theme'] = 'default';
$config['defaultModule'] = 'HelpDesk';
$config['timezone'] = 'Europe/Warsaw';
$config['languages'] = [
	'en_us' => 'English',
	'pl_pl' => 'Polski',
];
$config['minScripts'] = false;
$config['debugApi'] = true;
$config['logs'] = false;
// Security
$config['apiKey'] = 'VMUwRByXHSq1bLW485ikfvcC97P6gJsz';
$config['serverName'] = 'test';
$config['serverPass'] = 'test';
$config['encryptDataTransfer'] = false;
$config['privateKey'] = 'config/private.key';
$config['publicKey'] = 'config/public.key';
$config['logo'] = 'layouts/Default/skins/images/logo.png';
/** If timezone is configured, try to set it */
if (isset($config['timezone']) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($config['timezone']);
}
