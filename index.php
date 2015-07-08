<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */
ini_set('html_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('YF_PATH_BASE', __DIR__);

require_once('core/Init.php');

$coreUI = new Core_WebUI();
$coreUI->process(new Core_Request($_REQUEST));
