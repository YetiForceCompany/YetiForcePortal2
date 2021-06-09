<?php
/**
 * The file contains: TreeView class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

/**
 * Class TreeView.
 */
class TreeView extends \YF\Modules\Base\Model\ListView
{
	/** {@inheritdoc} */
	protected $actionName = 'RecordsTree';

	/**
	 * Shopping cart object.
	 *
	 * @var Cart
	 */
	private $cart;

	/**
	 * Construct.
	 */
	public function __construct()
	{
		$this->cart = new Cart();
	}

	/**
	 * {@inheritdoc}
	 * Calculate the quantity of available.
	 *
	 * @return array
	 */
	public function getRecordsListModel(): array
	{
		if (!isset($this->recordsList['records'])) {
			$this->loadRecordsList();
		}

		$recordsListModel = parent::getRecordsListModel();
		foreach ($recordsListModel as $recordId => $recordModel) {
			$amountInCart = 0;
			if ($this->cart->has($recordId)) {
				$amountInCart = $this->cart->getAmount($recordId);
			}
			$recordModel->setRawValue('amountInShoppingCart', $amountInCart);
		}
		return $recordsListModel;
	}
}
