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
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$this->getListViewModel()->loadRecordsList();
		$viewer = $this->getViewer();
		$viewer->assign('SEARCH_TEXT', '');
		$viewer->assign('SEARCH', $this->request->get('search'));
		$viewer->assign('LEFT_SIDE_TEMPLATE', 'ShoppingCart/Summary.tpl');
		$viewer->assign('SHOPPING_CART_VIEW', true);
		$viewer->assign('HEADERS', $this->listViewModel->getHeaders());
		$viewer->assign('RECORDS', $this->listViewModel->getRecordsListModel());
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('COUNT', $this->listViewModel->getCount());
		$viewer->assign('LIST_VIEW_MODEL', $this->listViewModel);
		$viewer->assign('USER', \App\User::getUser());
		$viewer->assign('TOTAL_PRICE', $this->getListViewModel()->calculateTotalPriceNetto());
		$viewer->view($this->processTplName(), $moduleName);
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
		return 'Tree/Tree.tpl';
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
