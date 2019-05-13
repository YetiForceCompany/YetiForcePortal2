<?php
/**
 * The file contains a class: ShoppingCart.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use App\Purifier;
use YF\Modules\Base\View;
use YF\Modules\Products\Model\CartView;
use YF\Modules\Products\Model\ReferenceCart;

/**
 * Class ShoppingCart.
 */
class ShoppingCart extends View\ListView
{
	const CUSTOM_FIELDS = [
		'productname',
		'product_no',
		'ean',
		'pscategory',
		'productcode',
		'unit_price',
		'taxes',
		'imagename',
		'description'
	];

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$listViewModel = $this->getListViewModel()
			->setRawData(true)
			->setCustomFields(static::CUSTOM_FIELDS);
		$proceedUrl = 'index.php?module=Products&view=ProceedToCheckout';
		$readonly = false;
		if (!$this->request->isEmpty('reference_id')) {
			$readonly = true;
			$listViewModel->setCart(new ReferenceCart($this->request->getInteger('reference_id'), $this->request->getByType('reference_module', Purifier::ALNUM)));
			$proceedUrl .= '&reference_id=' . $this->request->getInteger('reference_id') . '&reference_module=' . $this->request->getByType('reference_module', Purifier::ALNUM);
		}
		$listViewModel->loadRecordsList();
		$this->viewer->assign('RECORDS', $this->getListViewModel()->getRecordsListModel());
		$this->viewer->assign('MODULE_NAME', $moduleName);
		$this->viewer->assign('COUNT', $this->getListViewModel()->getCount());
		$this->viewer->assign('LIST_VIEW_MODEL', $this->getListViewModel());
		$this->viewer->assign('USER', \App\User::getUser());
		$this->viewer->assign('TOTAL_PRICE', $this->getListViewModel()->calculateTotalPriceNetto());
		$this->viewer->assign('ADDRESSES', $this->getListViewModel()->getAddresses());
		$this->viewer->assign('SELECTED_ADDRESS', $this->getListViewModel()->getSelectedAddress());
		$this->viewer->assign('PROCCED_URL', $proceedUrl);
		$this->viewer->assign('READONLY', $readonly);
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFooterScripts()
	{
		return array_merge(
			$this->convertScripts([YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . '/modules/Products/resources/Tree.js'], 'js'),
			parent::getFooterScripts()
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getListViewModel()
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = CartView::getInstance($this->moduleName, 'CartView');
		}
		return $this->listViewModel;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function processTplName(): string
	{
		return 'ShoppingCart/ShoppingCart.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function preProcessTplName(): string
	{
		return 'Tree/TreePreProcess.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function postProcessTplName(): string
	{
		return 'Tree/TreePostProcess.tpl';
	}
}
