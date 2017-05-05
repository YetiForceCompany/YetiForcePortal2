<?php
/**
 * Main file
 * @package YetiForce.Portal
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
error_reporting(E_ALL);
define('YF_ROOT', __DIR__);
define('YF_ROOT_PUBLIC', __DIR__ . DIRECTORY_SEPARATOR . 'public');
define('YF_ROOT_WWW', 'public/');

if (!file_exists(YF_ROOT . '/vendor/autoload.php')) {
	die('Please install dependencies via composer install.');
}
require_once(YF_ROOT . '/vendor/autoload.php');
require_once(YF_ROOT . '/core/errorhandler.php');

set_error_handler('exceptionErrorHandler');

session_save_path(YF_ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();

$coreUI = new \YF\Core\WebUI();
$coreUI->process(new \YF\Core\Request($_REQUEST));

//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

