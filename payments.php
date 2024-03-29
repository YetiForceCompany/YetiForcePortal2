<?php
/**
 * File to handle notifications from the payment system.
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
\define('ROOT_DIRECTORY', __DIR__ . DIRECTORY_SEPARATOR . '.');
\define('PUBLIC_DIRECTORY', '');

if (!file_exists(ROOT_DIRECTORY . '/vendor/autoload.php')) {
	echo 'Please install dependencies via composer install.';
	return;
}
require_once ROOT_DIRECTORY . '/vendor/autoload.php';
set_error_handler(['\\App\\Controller\\Base', 'exceptionErrorHandler']);
session_save_path(ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'session');
session_start();

use App\Log;

Log::init();
try {
	$paymentStatusMap = [
		\App\Payments\Utilities\TransactionState::STATUS_NEW => 'PLL_CREATED',
		\App\Payments\Utilities\TransactionState::STATUS_PROCESSING => 'PLL_CREATED',
		\App\Payments\Utilities\TransactionState::STATUS_COMPLETED => 'PLL_PAID',
		\App\Payments\Utilities\TransactionState::STATUS_REJECTED => 'PLL_DENIED',
	];
	$request = new \App\Request($_REQUEST);
	$paymentSystem = $request->getByType('paymentSystem', \App\Purifier::ALNUM);
	$payments = \App\Payments::getInstance($paymentSystem);
	if (!($payments instanceof \App\Payments\PaymentsSystemInterface)) {
		throw new \Exception('Wrong payment type.');
	}
	$transactionState = $payments->requestHandlingFromPaymentsSystem($request->getAllRaw());
	if (empty($paymentStatusMap[$transactionState->status])) {
		Log::error($transactionState, 'Payments');
		throw new \Exception('Unknown status of the transaction.');
	}
	if ($transactionState->crmOrderId < 1) {
		Log::error($transactionState, 'Payments');
		throw new \Exception('Incorrect CRM ID value.');
	}
	Log::info($transactionState, 'Payments');

	$api = new \App\Api([
		'Content-Type' => 'application/json',
		'X-ENCRYPTED' => 1,
		'X-API-KEY' => \App\Config::get('paymentApiKey'),
	], [
		'auth' => [\App\Config::get('paymentServerName'), \App\Config::get('paymentServerPass')],
	]);
	$answerfromApi = $api->call('ReceiveFromPaymentsSystem', [
		'ssingleordersid' => $transactionState->crmOrderId,
		'paymentsin_status' => $paymentStatusMap[$transactionState->status],
		'transaction_id' => $transactionState->transactionId,
		'paymentsvalue' => $transactionState->amount,
		'payments_original_value' => $transactionState->originalAmount,
		'currency_id' => $transactionState->currency,
		'payments_original_currency' => $transactionState->originalCurrency,
		'paymentstitle' => $transactionState->description,
		'payment_system' => $payments->getPicklistValue(),
	], 'PUT');
	echo $payments->successAnswerForPaymentSystem();
} catch (\Throwable $exception) {
	header('HTTP/1.1 400 Bad request');
	Log::error($exception->getMessage(), 'Payments');
}
