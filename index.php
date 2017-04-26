<?php
/**
 * Main file
 * @package YetiForce.Portal
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
error_reporting(E_ALL);
define('YF_ROOT', __DIR__);

require_once('libraries/vendor/autoload.php');
if (!file_exists('vendor/autoload.php')) {
	throw new \AppException('Please install dependencies via composer install.');
}
require_once('vendor/autoload.php');

session_save_path(YF_ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();

$coreUI = new Core\WebUI();
$coreUI->process(new Core\Request($_REQUEST));

//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

