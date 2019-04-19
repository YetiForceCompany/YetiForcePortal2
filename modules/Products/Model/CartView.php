<?php
/**
 * The file contains: Cart model view class.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

use YF\Modules\Base\Model\ListView as ListViewModel;
use YF\Modules\Base\Model\Record;

/**
 * Cart view model class.
 */
class CartView extends ListViewModel
{
	/**
	 * Shopping cart.
	 *
	 * @var Cart
	 */
	private $cart;

	/**
	 * List of products.
	 *
	 * @var Record[]
	 */
	private $recordsListModel = [];

	/**
	 * {@inheritdoc}
	 */
	public static function getInstance(string $moduleName)
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', 'CartView');
		return new $handlerModule($moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	public function __construct(string $moduleName)
	{
		$this->setModuleName($moduleName);
		$this->cart = new Cart();
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadRecordsList(): ListViewModel
	{
		$this->setConditions([
			'fieldName' => 'id',
			'value' => array_keys($this->cart->getAll()),
			'operator' => 'e'
		]);
		return parent::loadRecordsList();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRecordsListModel(): array
	{
		$this->recordsListModel = parent::getRecordsListModel();
		foreach ($this->recordsListModel as $key => $recordModel) {
			$recordModel->set('amountInShoppingCart', $this->cart->getAmount($key));
			$recordModel->set('totalPriceNetto', $this->cart->getAmount($key) * (float) $recordModel->get('unit_price'));
		}
		return $this->recordsListModel;
	}

	/**
	 * Calculate total price netto.
	 *
	 * @return float
	 */
	public function calculateTotalPriceNetto(): float
	{
		$totalPrice = 0;
		foreach ($this->cart->getAll() as $item) {
			$totalPrice += ((float) $item['param']['priceNetto']) * $item['amount'];
		}
		return $totalPrice;
	}
}
