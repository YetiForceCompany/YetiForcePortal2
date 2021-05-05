<?php
/**
 * The file contains: Cart model class.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

use App\Api;
use App\Session;

/**
 * Cart model class.
 */
class Cart
{
	/**
	 * Address.
	 *
	 * @var array
	 */
	protected $address = [];
	/**
	 * List of items in the cart.
	 *
	 * @var array
	 */
	protected $cart = [];
	/**
	 * Method payments.
	 *
	 * @var string
	 */
	protected $methodPayments = '';
	/**
	 * Attention.
	 *
	 * @var string
	 */
	protected $attention = '';

	/**
	 * Shipping price.
	 *
	 * @var float
	 */
	protected $shippingPrice;

	/**
	 * Get the number of items in the cart.
	 *
	 * @return int
	 */
	public static function getCount(): int
	{
		return (new static())->count();
	}

	/**
	 * Construct.
	 */
	public function __construct()
	{
		$this->cart = Session::get('Products.Cart', []);
		$this->address = Session::get('Products.Address', []);
		$this->methodPayments = Session::get('Products.MethodPayments', '');
		$this->attention = Session::get('Products.Attention', '');
	}

	/**
	 * Get all items from the shopping cart.
	 *
	 * @return array
	 */
	public function getAll(): array
	{
		return $this->cart;
	}

	/**
	 * Returns address.
	 *
	 * @return array
	 */
	public function getAddress(): array
	{
		return $this->address;
	}

	/**
	 * Returns address.
	 *
	 * @return array
	 */
	public function getPayment(): string
	{
		return $this->methodPayments;
	}

	/**
	 * Sets address.
	 *
	 * @param array $address
	 *
	 * @return void
	 */
	public function setAddress(array $address)
	{
		$this->address = $address;
	}

	/**
	 * Sets address.
	 *
	 * @param array  $address
	 * @param string $methodPayments
	 *
	 * @return void
	 */
	public function setMethodPayments(string $methodPayments)
	{
		$this->methodPayments = $methodPayments;
	}

	/**
	 * Sets address.
	 *
	 * @param array  $address
	 * @param string $methodPayments
	 * @param string $attention
	 *
	 * @return void
	 */
	public function setAttention(string $attention)
	{
		$this->attention = $attention;
	}

	/**
	 * Get number of items.
	 *
	 * @return int
	 */
	public function count(): int
	{
		$numberOfItems = 0;
		foreach ($this->cart as $item) {
			$numberOfItems += $item['amount'];
		}
		return $numberOfItems;
	}

	/**
	 * Add item to cart.
	 *
	 * @param int $recordId
	 * @param int $amount
	 *
	 * @return void
	 */
	public function add(int $recordId, int $amount)
	{
		$this->check($amount);
		$this->set($recordId, $this->getAmount($recordId) + $amount);
	}

	/**
	 * Subtract item from cart.
	 *
	 * @param int $recordId
	 * @param int $amount
	 *
	 * @return void
	 */
	public function subtract(int $recordId, int $amount)
	{
		if (!$this->has($recordId)) {
			throw new \App\Exceptions\AppException('Acting on a non-existent element');
		}
		$this->check($amount);
		$currentAmount = $this->getAmount($recordId) - $amount;
		if ($currentAmount <= 0) {
			$this->remove($recordId);
		} else {
			$this->set($recordId, $currentAmount);
		}
	}

	/**
	 * Get the quantity of the item in the shopping cart.
	 *
	 * @param int $recordId
	 *
	 * @return int
	 */
	public function get(int $recordId): array
	{
		return $this->cart[$recordId] ?? [];
	}

	/**
	 * Get amount.
	 *
	 * @param int $recordId
	 *
	 * @return int
	 */
	public function getAmount(int $recordId): int
	{
		return $this->cart[$recordId]['amount'] ?? 0;
	}

	/**
	 * Set item.
	 *
	 * @param int   $recordId
	 * @param int   $amount
	 * @param array $param
	 *
	 * @return void
	 */
	public function set(int $recordId, int $amount, array $param = [])
	{
		$this->check($amount);
		if ($this->has($recordId) && empty($param)) {
			$param = $this->cart[$recordId]['param'];
		}
		$this->cart[$recordId] = [
			'amount' => $amount,
			'param' => $param,
		];
	}

	/**
	 * Check if there is an element in the shopping cart.
	 *
	 * @param int $recordId
	 *
	 * @return bool
	 */
	public function has(int $recordId): bool
	{
		return isset($this->cart[$recordId]);
	}

	/**
	 * Remove item.
	 *
	 * @param int $recordId
	 *
	 * @return void
	 */
	public function remove(int $recordId)
	{
		if ($this->has($recordId)) {
			unset($this->cart[$recordId]);
		}
	}

	/**
	 * Remove all items.
	 *
	 * @return void
	 */
	public function removeAll()
	{
		$this->cart = [];
		$this->attention = '';
	}

	/**
	 * Save cart.
	 *
	 * @return void
	 */
	public function save()
	{
		Session::set('Products.Cart', $this->cart);
		Session::set('Products.Address', $this->address);
		Session::set('Products.MethodPayments', $this->methodPayments);
		Session::set('Products.Attention', $this->attention);
	}

	/**
	 * Check if the quantity is correct.
	 *
	 * @param int $amount
	 *
	 * @return void
	 */
	private function check(int $amount)
	{
		if ($amount < 1) {
			throw new \App\Exceptions\AppException('Invalid argument');
		}
	}

	/**
	 * Calculate total price netto.
	 *
	 * @return float
	 */
	public function calculateTotalPriceNetto(): float
	{
		$totalPrice = 0;
		foreach ($this->cart as $item) {
			$totalPrice += ((float) $item['param']['priceNetto']) * $item['amount'];
		}
		return $totalPrice;
	}

	/**
	 * Calculate total price netto.
	 *
	 * @return float
	 */
	public function calculateTotalPriceGross(): float
	{
		$totalPrice = 0;
		foreach ($this->cart as $item) {
			$totalPrice += ((float) $item['param']['priceGross']) * $item['amount'];
		}
		return $totalPrice + $this->getShippingPrice();
	}

	public function getAttention(): ?string
	{
		return $this->attention;
	}

	/**
	 * Gets shipping price.
	 */
	public function getShippingPrice()
	{
		if (!\App\Config::getBool('addDelivery')) {
			return 0;
		}
		if (isset($this->shippingPrice)) {
			return $this->shippingPrice;
		}
		$data = [];
		foreach ($this->cart as $productId => $info) {
			$data[] = [
				'productId' => $productId,
				'qty' => $info['amount']
			];
		}
		$results = Api::getInstance()->call('SSingleOrders/Delivery/?' . http_build_query(['products' => $data]));
		return $results['price'] ?? 0;
	}
}
