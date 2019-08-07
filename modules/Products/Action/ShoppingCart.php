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

use App\Purifier;
use YF\Modules\Products\Model\Cart;

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
		$this->exposeMethod('changeAddress');
		$this->exposeMethod('setMethodPayments');
		$this->exposeMethod('setAttention');
	}

	/**
	 * Set the amount of the item.
	 *
	 * @return void
	 */
	public function setToCart()
	{
		$this->cart->set($this->request->getInteger('record'), $this->request->getInteger('amount', 1), [
			'priceNetto' => (float) $this->request->get('priceNetto', 0.0),
			'priceGross' => (float) $this->request->get('priceGross', 0.0)
		]);
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
			$this->cart->set($recordId, $amount, [
				'priceNetto' => (float) $this->request->get('priceNetto', 0.0),
				'priceGross' => (float) $this->request->get('priceGross', 0.0)
			]);
		}
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
	 * Change address.
	 *
	 * @return void
	 */
	public function changeAddress()
	{
		$this->cart->setAddress([
			'addresslevel1' => $this->request->getByType('addresslevel1', 'Text'),
			'addresslevel2' => $this->request->getByType('addresslevel2', 'Text'),
			'addresslevel3' => $this->request->getByType('addresslevel3', 'Text'),
			'addresslevel4' => $this->request->getByType('addresslevel4', 'Text'),
			'addresslevel5' => $this->request->getByType('addresslevel5', 'Text'),
			'addresslevel6' => $this->request->getByType('addresslevel6', 'Text'),
			'addresslevel7' => $this->request->getByType('addresslevel7', 'Text'),
			'addresslevel8' => $this->request->getByType('addresslevel8', 'Text'),
			'localnumber' => $this->request->getByType('localnumber', 'Text'),
			'buildingnumber' => $this->request->getByType('buildingnumber', 'Text'),
			'pobox' => $this->request->getByType('pobox', 'Text'),
		]);
		$this->cart->save();
		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}

	/**
	 * Save the shopping cart.
	 *
	 * @return void
	 */
	private function saveCart()
	{
		$totalPrice = $this->cart->calculateTotalPriceGross();
		$companyDetails = \App\User::getUser()->get('companyDetails');
		if (!empty($companyDetails) && isset($companyDetails['creditlimit']) && $totalPrice > ($companyDetails['creditlimit'] - $companyDetails['sum_open_orders'])) {
			$result = [
				'error' => \App\Language::translate('LBL_MERCHANT_LIMIT_EXCEEDED', 'Products')
			];
		} else {
			$this->cart->save();
			$result = [
				'numberOfItems' => $this->cart->count(),
				'totalPriceNetto' => \App\Fields\Currency::formatToDisplay($this->cart->calculateTotalPriceNetto()),
				'totalPriceGross' => \App\Fields\Currency::formatToDisplay($totalPrice),
				'shippingPrice' => \App\Fields\Currency::formatToDisplay($this->cart->getShippingPrice()),
			];
		}

		$response = new \App\Response();
		$response->setResult($result);
		$response->emit();
	}

	/**
	 * Change method payments.
	 *
	 * @return void
	 */
	public function setMethodPayments()
	{
		$this->cart->setMethodPayments($this->request->getByType('method', Purifier::ALNUM));
		$this->cart->save();
		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}

	/**
	 * Change attention.
	 *
	 * @return void
	 */
	public function setAttention()
	{
		$this->cart->setAttention($this->request->getByType('attention', Purifier::TEXT));
		$this->cart->save();
		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}
}
