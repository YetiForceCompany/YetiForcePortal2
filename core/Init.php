<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

require_once('config/version.php');
require_once('core/Loader.php');
Core_Loader::import('core/Functions.php');

$parts = explode(DIRECTORY_SEPARATOR, YF_PATH_BASE);
define('YF_PATH_ROOT', implode(DIRECTORY_SEPARATOR, $parts));

session_save_path(YF_PATH_ROOT . DIRECTORY_SEPARATOR . 'cache ' . DIRECTORY_SEPARATOR . 'session');
session_start();




