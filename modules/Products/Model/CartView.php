<?php
/**
 * The file contains: Cart model view class.
 *
 * @package   Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

use App\Api;
use YF\Modules\Base\Model\AbstractListView;
use YF\Modules\Base\Model\ListView as ListViewModel;
use YF\Modules\Base\Model\Record;

/**
 * Cart view model class.
 */
class CartView extends ListViewModel
{
	const ADDRESS_FIELDS = ['addresslevel1', 'addresslevel2', 'addresslevel3', 'addresslevel4', 'addresslevel5', 'addresslevel6',  'addresslevel7', 'addresslevel8',  'buildingnumber', 'localnumber', 'pobox'];

	/** @var Shopping cart */
	private $cart;

	/**
	 * List of products.
	 *
	 * @var Record[]
	 */
	private $recordsListModel = [];

	/** {@inheritdoc} */
	protected $actionName = 'RecordsTree';

	/** {@inheritdoc} */
	public function __construct()
	{
		$this->cart = new Cart();
	}

	public function setCart($cart)
	{
		$this->cart = $cart;
	}

	/** {@inheritdoc} */
	public function loadRecordsList(): AbstractListView
	{
		$card = $this->cart->getAll();
		if ($card) {
			$this->setConditions([
				'fieldName' => 'id',
				'value' => array_keys($card),
				'operator' => 'e',
			]);
			return parent::loadRecordsList();
		}
		$this->recordsList = [];

		return $this;
	}

	/** {@inheritdoc} */
	public function getRecordsListModel(): array
	{
		$this->recordsListModel = parent::getRecordsListModel();
		foreach ($this->recordsListModel as $recordId => $recordModel) {
			$amount = $this->cart->getAmount($recordId);
			$recordDetail = $this->cart->get($recordId);
			$priceNet = (float) ($recordDetail['param']['priceNetto'] ?? 0);
			$priceGross = (float) ($recordDetail['param']['priceGross'] ?? 0);
			$recordModel->set('amountInShoppingCart', $amount);
			$recordModel->set('totalPriceNetto', $amount * $priceNet);
			$recordModel->set('totalPriceGross', $amount * $priceGross);
			$recordModel->set('priceNetto', $priceNet);
			$recordModel->set('priceGross', $priceGross);
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
		return $this->cart->calculateTotalPriceNetto();
	}

	/**
	 * Calculate total price gross.
	 *
	 * @return float
	 */
	public function calculateTotalPriceGross(): float
	{
		return $this->cart->calculateTotalPriceGross();
	}

	/**
	 * Returns addresses for account.
	 *
	 * @return array
	 */
	public function getAddresses(): array
	{
		$userModel = \App\User::getUser();
		if (empty($userModel->get('companyId'))) {
			return [];
		}
		$accountRecordDetail = Api::getInstance()->setCustomHeaders(['x-raw-data' => 1])->call("Accounts/Record/{$userModel->get('companyId')}", [], 'get');
		$address = [];
		foreach (['a', 'b', 'c'] as $typeAddress) {
			if (empty($accountRecordDetail['data']['addresslevel5' . $typeAddress])) {
				continue;
			}
			$address[$typeAddress] = array_intersect_key($accountRecordDetail['data'], array_flip(
				array_map(function ($val) use ($typeAddress) {
					return $val . $typeAddress;
				}, static::ADDRESS_FIELDS)
			));
		}
		$fields = [];
		foreach (static::ADDRESS_FIELDS as $field) {
			$fields[$field . 'a'] = $accountRecordDetail['fields'][$field . 'a'] ?? '';
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

	public function getAttention(): ?string
	{
		return $this->cart->getAttention();
	}

	/**
	 * Returns selected address.
	 *
	 * @return array
	 */
	public function getSelectedPayment(): ?\App\Payments\PaymentsInterface
	{
		$payment = $this->cart->getPayment();
		if (!$payment) {
			return null;
		}
		return \App\Payments::getInstance($this->cart->getPayment());
	}

	/**
	 * Gets shipping price.
	 *
	 * @return void
	 */
	public function getShippingPrice()
	{
		return $this->cart->getShippingPrice();
	}
}
