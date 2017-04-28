<?php
/**
 * Travis CI test script
 * @package YetiForce.Tests
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Micha³ Lorencik <m.lorencik@yetiforce.com>
 */
chdir(dirname(__FILE__) . '/../');

$startTime = microtime(true);
define('YF_ROOT', __DIR__);

session_start();

require_once('libraries/vendor/autoload.php');
if (!file_exists('vendor/autoload.php')) {
	throw new \AppException('Please install dependencies via composer install.');
}
require_once('vendor/autoload.php');

$coreUI = new Core\WebUI();
$coreUI->process(new Core\Request($_REQUEST));

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
