<?php
/**
 * The file contains: buy action class.
 *
 * @package   Action
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Action;

use App\Purifier;
use YF\Modules\Products\Model\Cart;
use YF\Modules\Products\Model\ReferenceCart;

/**
 * Buy action class.
 */
class Buy extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$response = new \App\Response();
		try {
			$paymentMethod = '';
			if ($this->request->isEmpty('reference_id')) {
				$cart = new Cart();
				$responseFromApi = $this->createSingleOrderFromCart($cart);
				if (!isset($responseFromApi['errors'])) {
					$paymentMethod = $cart->getPayment();
					$_SESSION['user']['companyDetails']['sum_open_orders'] = $_SESSION['user']['companyDetails']['sum_open_orders'] + $cart->calculateTotalPriceGross();
					$cart->removeAll();
					$cart->save();
				}
			} else {
				$cart = new ReferenceCart($this->request->getInteger('reference_id'), $this->request->getByType('reference_module', Purifier::ALNUM));
				$responseFromApi = $this->createSingleOrderFromCart($cart);
				if (!isset($responseFromApi['errors'])) {
					$paymentMethod = $cart->getPayment();
					$_SESSION['user']['companyDetails']['sum_open_orders'] = $_SESSION['user']['companyDetails']['sum_open_orders'] + $cart->calculateTotalPriceGross();
				}
			}
			if (!empty($paymentMethod)) {
				$payment = \App\Payments::getInstance($paymentMethod);
				$payment->setCrmOrderId($responseFromApi['id']);
				if ($payment instanceof \App\Payments\PaymentsSystemInterface) {
					$payment->setDescription($responseFromApi['id']); //Insert the order title here
					if ($payment instanceof \App\Payments\PaymentsMultiCurrencyInterface) {
						$payment->setCurrency('PLN');
					}
					$payment->setAmount($cart->calculateTotalPriceGross());
					if ('GET' === $payment->getTypeOfOutputCommunication()) {
						$responseFromApi['paymentUrl'] = $payment->generatePaymentURL();
					} else {
						$responseFromApi['paymentUrl'] = $payment->getPaymentExecutionURL();
						$responseFromApi['paymentPostData'] = $payment->getParametersForForm();
					}
				} else {
					$responseFromApi['paymentUrl'] = $payment->getUrlReturn();
				}
			}
			$response->setResult($responseFromApi);
		} catch (\App\AppException $e) {
			$response->setError($e->getCode(), $e->getMessage());
		}
		$response->emit();
	}

	/**
	 * Create single order.
	 *
	 * @param Cart $cart
	 *
	 * @return array
	 */
	private function createSingleOrderFromCart(Cart $cart)
	{
		$dataInventory = [];
		foreach ($cart->getAll() as $key => $item) {
			$dataInventory[$key] = [
				'name' => $key,
				'qty' => $item['amount']
			];
		}
		$requestParams = [];
		foreach ($cart->getAddress() as $fieldName => $value) {
			$requestParams[$fieldName . 'a'] = $value;
		}
		$requestParams['ssingleorders_method_payments'] = \App\Payments::getInstance($cart->getPayment())->getPicklistValue();
		$requestParams['ssingleorders_source'] = 'PLL_PORTAL';
		if ($cart instanceof  ReferenceCart) {
			$requestParams['reference_id'] = $cart->recordId;
			$requestParams['reference_module'] = $cart->moduleName;
		}
		$requestParams['inventory'] = $dataInventory;
		$requestParams['subject'] = 'SSingleOrders - ' . date('Y-m-d');
		return \App\Api::getInstance()->call('SSingleOrders/SaveInventory/', $requestParams, 'post');
	}
}
