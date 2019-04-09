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

use App\Request;
use YF\Modules\Base\View;
use YF\Modules\Products\Model\Tree as TreeModel;

/**
 * Class Tree.
 */
class Tree extends View\ListView
{
	private $pscategory = [];

	public function preProcessAjax(Request $request)
	{
		$this->preProcess($request);
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcess(Request $request, $display = true)
	{
		parent::preProcess($request, $display);
		$this->listViewModel
			->setCustomFields([
				'productname',
				'product_no',
				'ean',
				'pscategory',
				'productcode',
				'unit_price',
				'taxes',
				'imagename',
				'description'
			])->setLimit(10)
			->setPage($request->get('page', 1));
		if ($request->has('search') && !$request->isEmpty('search')) {
			$serach = $request->get('search');

			//TODO - validation
			$this->listViewModel->setConditions($serach);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function process(Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('SEARCH_TEXT', '');
		$viewer->assign('SEARCH', $request->get('search'));
		$viewer->assign(
			'TREE',
			TreeModel::getInstance()
				->setSelectedItems($this->pscategory)
				->getTree()
		);
		parent::process($request);
	}

	/**
	 * {@inheritdoc}
	 */
	public function processTplName(Request $request = null): string
	{
		return $request->getAction() . '/' .
			($request->isAjax() ? 'TreeItems.tpl' : 'Tree.tpl');
	}
}
