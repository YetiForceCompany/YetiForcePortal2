<?php
/**
 * Main file.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
if (!\defined('ROOT_DIRECTORY')) {
	\define('ROOT_DIRECTORY', __DIR__);
}
if (!\defined('PUBLIC_DIRECTORY')) {
	\define('PUBLIC_DIRECTORY', 'public_html/');
}

if (!file_exists(ROOT_DIRECTORY . '/vendor/autoload.php')) {
	echo 'Please install dependencies via composer install.';
	return;
}
require_once ROOT_DIRECTORY . '/vendor/autoload.php';

set_error_handler(['\\App\\Controller\\Base', 'exceptionErrorHandler']);

\App\Session::init();

\App\Config::$startTime = microtime(true);
\App\Cache::init();

$coreUI = new \App\WebUI();
$coreUI->process(new \App\Request($_REQUEST));
