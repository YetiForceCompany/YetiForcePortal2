<?php
/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */

define('YF_PATH_BASE', __DIR__ );

require_once('core/Init.php');

$coreUI = new Core_WebUI();
$coreUI->process(new Core_Request($_REQUEST));
