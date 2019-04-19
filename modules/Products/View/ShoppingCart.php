<?php
/**
 * Tree view class.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use YF\Modules\Base\View;
use YF\Modules\Products\Model\CartView;

/**
 * Class Tree.
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
		$this->getListViewModel()
			->setRawData(true)
			->setCustomFields(static::CUSTOM_FIELDS)
			->loadRecordsList();
		$this->viewer->assign('SEARCH_TEXT', '');
		$this->viewer->assign('SEARCH', $this->request->get('search'));
		$this->viewer->assign('LEFT_SIDE_TEMPLATE', 'ShoppingCart/Summary.tpl');
		$this->viewer->assign('SHOPPING_CART_VIEW', true);
		$this->viewer->assign('HEADERS', $this->getListViewModel()->getHeaders());
		$this->viewer->assign('RECORDS', $this->getListViewModel()->getRecordsListModel());
		$this->viewer->assign('MODULE_NAME', $moduleName);
		$this->viewer->assign('COUNT', $this->getListViewModel()->getCount());
		$this->viewer->assign('LIST_VIEW_MODEL', $this->getListViewModel());
		$this->viewer->assign('USER', \App\User::getUser());
		$this->viewer->assign('TOTAL_PRICE', $this->getListViewModel()->calculateTotalPriceNetto());
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
			$this->listViewModel = CartView::getInstance($this->moduleName);
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
