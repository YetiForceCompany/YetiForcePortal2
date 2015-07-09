<?php
/**
 * System files loader
 * @license licenses/License.html
 * @package YetiForce.Config
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
defined('_EXEC') or die;

require_once('config/version.php');
require_once('core/Loader.php');
Core_Loader::import('core/Functions.php');

/**
 * Change location for session
 */
session_save_path(YF_ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();




