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

use YF\Modules\Products\Model\Cart;

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
			$response->setResult($this->createSingleOrder());
		} catch (\App\AppException $e) {
			$response->setError($e->getCode(), $e->getMessage());
		}
		$response->emit();
	}

	/**
	 * Create single order.
	 *
	 * @return array
	 */
	private function createSingleOrder()
	{
		$cart = new Cart();
		$data = [];
		foreach ($cart->getAll() as $key => $item) {
			$data[$key] = [
				'name' => $key,
				'qty' => $item['amount']
			];
		}
		return \App\Api::getInstance()->call(
			'SSingleOrders/SaveInventory/',
			['sourceModule' => 'SSingleOrders', 'inventory' => $data],
			'post'
		);
	}
}
