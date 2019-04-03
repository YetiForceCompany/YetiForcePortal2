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
			'unit_price',
			'imagename',
			'description'
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function processTplName(Request $request = null): string
	{
		return $request->getAction() . '/Tree.tpl';
	}
}
