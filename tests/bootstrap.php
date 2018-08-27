<?php
/**
 * Travis CI test script
 * @package YetiForce.Tests
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Michał Lorencik <m.lorencik@yetiforce.com>
 */
chdir(dirname(__FILE__) . '/../');

$startTime = microtime(true);
define('YF_ROOT', __DIR__);

session_start();


if (!file_exists('vendor/autoload.php')) {
	die('Please install dependencies via composer install.');
}
require_once('vendor/autoload.php');

$coreUI = new \App\WebUI();
$coreUI->process(new \App\Request($_REQUEST));

//fix phpunit console for windows
if (!getenv('ANSICON')) {
	putenv('ANSICON=80');
}

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', ROOT_DIRECTORY . 'cache/logs/phpError.log');
ini_set('output_buffering', 'On');
ini_set('max_execution_time', 600);
ini_set('default_socket_timeout', 600);
ini_set('post_max_size', '200M');
ini_set('upload_max_filesize', '200M');
ini_set('max_input_vars', 10000);
ini_set('xdebug.enable', 'On');
