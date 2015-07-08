<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */
$config = [];
$config['crmPath'] = 'http://yeti/';
$config['apiLogin'] = 'test';
$config['apiPass'] = 'test';
$config['language'] = 'pl_pl';
$config['theme'] = 'default';
$config['defaultModule'] = 'HelpDesk';
$config['timezone'] = 'Europe/Warsaw';
$config['languages'] = [
	'en_us' => 'English',
	'pl_pl' => 'Polski',
];
$config['minScripts'] = false;
$config['logo'] = 'layouts/main/skins/images/logo.png';
/** If timezone is configured, try to set it */
if (isset($config['timezone']) && function_exists('date_default_timezone_set')) {
	@date_default_timezone_set($config['timezone']);
}
