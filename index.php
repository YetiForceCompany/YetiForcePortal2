<?php
/**
 * Main file
 * @package YetiForce.Portal
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
error_reporting(E_ALL);
define('YF_ROOT', __DIR__);
define('_EXEC', 1);

require_once('core/Init.php');

$coreUI = new \Core\WebUI();
$coreUI->process(new \Core\Request($_REQUEST));
