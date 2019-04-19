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
			->setPage($this->request->get('page', 1));
		if ($this->request->has('search') && !$this->request->isEmpty('search')) {
			$serach = $this->request->get('search');

			//TODO - validation
			$this->getListViewModel()->setConditions($serach);
		}
		$this->viewer->assign('SEARCH_TEXT', '');
		$this->viewer->assign('SEARCH', $this->request->get('search'));
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
}
