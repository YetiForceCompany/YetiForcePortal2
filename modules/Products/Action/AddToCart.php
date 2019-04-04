<?php

/**
 * Add to cart action class.
 *
 * @package   Action
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\Action;

/**
 * AddToCart class.
 */
class AddToCart extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function process(\App\Request $request)
	{
		$response = new \App\Response();
		$response->setResult(['data' => 1]);
		$response->emit();
	}
}
