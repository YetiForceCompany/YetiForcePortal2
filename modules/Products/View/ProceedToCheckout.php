<?php
/**
 * The file contains a class: ProceedToCheckout.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

/**
 * Class ProceedToCheckout.
 */
class ProceedToCheckout extends ShoppingCart
{
	/**
	 * {@inheritdoc}
	 */
	protected function processTplName(): string
	{
		return 'ProceedToCheckout/ProceedToCheckout.tpl';
	}
}
