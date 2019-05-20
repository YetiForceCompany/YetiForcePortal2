<?php
/**
 * The file contains: TreeView class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Model;

use YF\Modules\Base\Model\AbstractListView;

/**
 * Class TreeView.
 */
class TreeView extends AbstractListView
{
	/**
	 * {@inheritdoc}
	 */
	protected $actionName = 'RecordsTree';

	/**
	 * Shopping cart object.
	 *
	 * @var Cart
	 */
	private $cart;

	/**
	 * Construct.
	 *
	 * @param string $moduleName
	 */
	public function __construct(string $moduleName)
	{
		parent::__construct($moduleName);
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
