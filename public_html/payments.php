<?php
/**
 * File to handle notifications from the payment system.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('YF_ROOT', __DIR__ . DIRECTORY_SEPARATOR . '..');
define('YF_ROOT_WEB', __DIR__);
define('YF_ROOT_WWW', '');

if (!file_exists(YF_ROOT . '/vendor/autoload.php')) {
	die('Please install dependencies via composer install.');
}
require_once YF_ROOT . '/vendor/autoload.php';
set_error_handler(['\\App\\Controller\\Base', 'exceptionErrorHandler']);
session_save_path(YF_ROOT . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();

try {
	$request = new \App\Request($_REQUEST);
	$payments = \App\Payments::getInstance($request->get('paymentSystem'));
	$transactionState = $payments->requestHandlingFromPaymentsSystem($request->getAllRaw());
	$answerfromApi = \App\Api::getInstance()->call('ReceiveFromPaymentsSystem', [
		'crmOrderId' => $transactionState->crmOrderId,
		'transactionState' => $transactionState,
	], 'PUT');
	echo $payments->successAnswerForPaymentSystem();
} catch (\Throwable $exception) {
	header('HTTP/1.1 400 Bad request');
	//Logi
}
