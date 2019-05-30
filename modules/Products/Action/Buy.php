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
			if ($this->request->isEmpty('reference_id')) {
				$cart = new Cart();
				$responseFromApi = $this->createSingleOrderFromCart($cart);
				$response->setResult($responseFromApi);
				if (!isset($responseFromApi['errors'])) {
					$_SESSION['user']['companyDetails']['sum_open_orders'] = $_SESSION['user']['companyDetails']['sum_open_orders'] + $cart->calculateTotalPriceGross();
					$cart->removeAll();
					$cart->save();
				}
			} else {
				$cart = new ReferenceCart($this->request->getInteger('reference_id'), $this->request->getByType('reference_module', Purifier::ALNUM));
				$responseFromApi = $this->createSingleOrderFromCart($cart);
				if (!isset($responseFromApi['errors'])) {
					$_SESSION['user']['companyDetails']['sum_open_orders'] = $_SESSION['user']['companyDetails']['sum_open_orders'] + $cart->calculateTotalPriceGross();
				}
				$response->setResult($responseFromApi);
			}
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
		if ($cart instanceof  ReferenceCart) {
			$requestParams['reference_id'] = $cart->recordId;
			$requestParams['reference_module'] = $cart->moduleName;
		}
		$requestParams['inventory'] = $dataInventory;
		$requestParams['subject'] = 'SSingleOrders - ' . date('Y-m-d');
		return \App\Api::getInstance()->call('SSingleOrders/SaveInventory/', $requestParams, 'post');
	}
}
