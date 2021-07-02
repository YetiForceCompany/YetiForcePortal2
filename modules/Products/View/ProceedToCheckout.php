<?php
/**
 * The file contains a class: ProceedToCheckout.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use App\Purifier;

/**
 * Class ProceedToCheckout.
 */
class ProceedToCheckout extends ShoppingCart
{
	/** {@inheritdoc} */
	public function process()
	{
		if ($this->request->isEmpty('reference_id')) {
			$this->viewer->assign('REFERENCE_ID', null);
			$this->viewer->assign('REFERENCE_MODULE', null);
		} else {
			$this->viewer->assign('REFERENCE_ID', $this->request->getInteger('reference_id'));
			$this->viewer->assign('REFERENCE_MODULE', $this->request->getByType('reference_module', Purifier::ALNUM));
		}
		parent::process();
	}

	/** {@inheritdoc} */
	protected function processTplName(): string
	{
		return 'ProceedToCheckout/ProceedToCheckout.tpl';
	}
}
