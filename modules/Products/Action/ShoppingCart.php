<?php
/**
 * The file contains: shopping cart action class.
 *
 * @package   Action
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Action;

use YF\Modules\Products\Model\Cart;
use YF\Modules\Products\Model\CartView;

/**
 * Shopping cart action class.
 */
class ShoppingCart extends \App\Controller\Action
{
	use \App\Controller\ExposeMethodTrait;

	/**
	 * Shopping cart object.
	 *
	 * @var Cart
	 */
	private $cart;

	public function __construct(\App\Request $request)
	{
		parent::__construct($request);
		$this->cart = new Cart();
		$this->exposeMethod('setToCart');
		$this->exposeMethod('addToCart');
		$this->exposeMethod('removeFromCart');
	}

	/**
	 * Set the amount of the item.
	 *
	 * @return void
	 */
	public function setToCart()
	{
		$this->cart->set($this->request->getInteger('record'), $this->request->getInteger('amount', 1), ['priceNetto' => (float) $this->request->get('priceNetto', 0.0)]);
		$this->cart->save();
		$this->saveCart();
	}

	/**
	 * Add the item to the shopping cart.
	 *
	 * @return void
	 */
	public function addToCart()
	{
		$recordId = $this->request->getInteger('record');
		$amount = $this->request->getInteger('amount', 1);
		if ($this->cart->has($recordId)) {
			$this->cart->add($recordId, $amount);
		} else {
			$this->cart->set($recordId, $amount, ['priceNetto' => (float) $this->request->get('priceNetto', 0.0)]);
		}
		$this->cart->save();
		$this->saveCart();
	}

	/**
	 * Remove the item from the shopping cart.
	 *
	 * @return void
	 */
	public function removeFromCart()
	{
		$this->cart->remove($this->request->getInteger('record'));
		$this->saveCart();
	}

	/**
	 * Save the shopping cart.
	 *
	 * @return void
	 */
	private function saveCart()
	{
		$this->cart->save();
		$cartViewModel = CartView::getInstance('Products');
		$response = new \App\Response();
		$response->setResult([
			'numberOfItems' => $this->cart->count(),
			'totalPriceNetto' => $cartViewModel->calculateTotalPriceNetto()
		]);
		$response->emit();
	}
}
