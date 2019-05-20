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
		try {
			$response = new \App\Response();
			if ($this->request->isEmpty('reference_id')) {
				$cart = new Cart();
				$responseFromApi = $this->createSingleOrderFromCart($cart);
				$response->setResult($responseFromApi);
				if (!isset($responseFromApi['error'])) {
					$cart->removeAll();
					$cart->save();
				}
			} else {
				$cart = new ReferenceCart($this->request->getInteger('reference_id'), $this->request->getByType('reference_module', Purifier::ALNUM));
				$response->setResult($this->createSingleOrderFromCart($cart));
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
		$data = [];
		foreach ($cart->getAll() as $key => $item) {
			$data[$key] = [
				'name' => $key,
				'qty' => $item['amount']
			];
		}
		return \App\Api::getInstance()->call(
			'SSingleOrders/SaveInventory/',
			[
				'inventory' => $data,
				'address' => $cart->getAddress()
			],
			'post'
		);
	}
}
