<?php
/**
 * Main file
 * @package YetiForce.Portal
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
error_reporting(E_ALL);
define('YF_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');
define('YF_ROOT_WEB', __DIR__);
define('YF_ROOT_WWW', '');

if (!file_exists(YF_ROOT . '/vendor/autoload.php')) {
	die('Please install dependencies via composer install.');
}
require_once(YF_ROOT . '/vendor/autoload.php');

set_error_handler('exceptionErrorHandler');

session_save_path(YF_ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();

$coreUI = new \YF\Core\WebUI();
$coreUI->process(new \YF\Core\Request($_REQUEST));

//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

