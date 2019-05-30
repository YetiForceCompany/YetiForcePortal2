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

use YF\Modules\Base\Model\ListView as ListViewModel;
use YF\Modules\Base\View;
use YF\Modules\Products\Model\Tree as TreeModel;

/**
 * Class Tree.
 */
class Tree extends View\ListView
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

	private $pscategory = [];

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$this->getListViewModel()
			->setRawData(true)
			->setCustomFields(static::CUSTOM_FIELDS)
			->setLimit(\App\Config::get('itemsPrePage'))
			->setPage($this->request->getInteger('page', 1));
		$search = [];
		if ($this->request->has('search') && !$this->request->isEmpty('search')) {
			$search = $this->request->get('search');
			$this->getListViewModel()->setConditions($search);
		}
		$this->viewer->assign('SEARCH_TEXT', '');
		$this->viewer->assign('SEARCH', $search);
		$this->viewer->assign('CHECK_STOCK_LEVELS', \App\User::getUser()->get('companyDetails')['check_stock_levels'] ?? false);
		parent::process();
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcess($display = true)
	{
		$this->viewer->assign('LEFT_SIDE_TEMPLATE', 'Tree/Category.tpl');
		$this->viewer->assign(
			'TREE',
			TreeModel::getInstance()
				->setSelectedItems($this->pscategory)
				->getTree()
		);
		parent::preProcess($display);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function processTplName(): string
	{
		return $this->request->getAction() . '/Tree.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function preProcessTplName(): string
	{
		return $this->request->getAction() . '/TreePreProcess.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function postProcessTplName(): string
	{
		return $this->request->getAction() . '/TreePostProcess.tpl';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getListViewModel()
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = ListViewModel::getInstance($this->moduleName, 'TreeView');
		}
		return $this->listViewModel;
	}
}
