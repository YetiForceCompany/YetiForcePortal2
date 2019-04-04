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
	/**
	 * {@inheritdoc}
	 */
	public function preProcess(Request $request, $display = true)
	{
		parent::preProcess($request, $display);
		$this->listViewModel->setCustomFields([
			'productname',
			'product_no',
			'ean',
			'pscategory',
			'productcode',
			'unit_price',
			'taxes',
			'imagename',
			'description'
		])->setLimit(20);
	}

	/**
	 * {@inheritdoc}
	 */
	public function process(Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('TREE', TreeModel::getInstance()->getTree());
		parent::process($request);
	}

	/**
	 * {@inheritdoc}
	 */
	public function processTplName(Request $request = null): string
	{
		return $request->getAction() . '/Tree.tpl';
	}
}
