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

use App\Api;
use YF\Modules\Base\Model\ListView as ListViewModel;
use YF\Modules\Base\Model\Record;

/**
 * Cart view model class.
 */
class CartView extends ListViewModel
{
	const ADDRESS_FIELDS = ['addresslevel1', 'addresslevel2', 'addresslevel3', 'addresslevel4', 'addresslevel5', 'addresslevel6',  'addresslevel7', 'addresslevel8',  'buildingnumber', 'localnumber', 'pobox'];
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

	public function setCart($cart)
	{
		$this->cart = $cart;
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
		foreach ($this->recordsListModel as $recordId => $recordModel) {
			$recordDetail = $this->cart->get($recordId);
			$recordModel->set('amountInShoppingCart', $this->cart->getAmount($recordId));
			$recordModel->set('totalPriceNetto', $this->cart->getAmount($recordId) * (float) $recordDetail['param']['priceNetto']);
			$recordModel->set('priceNetto', $recordDetail['param']['priceNetto']);
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

	/**
	 * Returns addresses for account.
	 *
	 * @return array
	 */
	public function getAddresses(): array
	{
		$userModel = \App\User::getUser();
		if (empty($userModel->get('CompanyId'))) {
			return [];
		}
		$accountRecordDetail = Api::getInstance()->setCustomHeaders(['X-RAW-DATA' => 1])->call("Accounts/Record/{$userModel->get('CompanyId')}", [], 'get');
		$address = [];

		foreach (['a', 'b', 'c'] as $typeAddress) {
			if (empty($accountRecordDetail['data']['addresslevel5' . $typeAddress])) {
				continue;
			}
			$address[$typeAddress]= array_intersect_key($accountRecordDetail['data'], array_flip(
				array_map(function ($val) use ($typeAddress) {
					return $val . $typeAddress;
				}, static::ADDRESS_FIELDS)
			));
		}
		$fields = [];
		foreach (static::ADDRESS_FIELDS as $field) {
			$fields[$field . 'a'] = $accountRecordDetail['fields'][$field . 'a'];
		}
		return ['data' => $address, 'fields' => $fields];
	}

	/**
	 * Returns selected address.
	 *
	 * @return array
	 */
	public function getSelectedAddress(): array
	{
		return $this->cart->getAddress();
	}
}
