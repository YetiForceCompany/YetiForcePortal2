<?php
/**
 * The file contains: View class for payment after purchase.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

/**
 * View class for payment after purchase.
 */
class PaymentAfterPurchase extends \App\Controller\View
{
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$resultOfReturn = \App\Payments::getInstance($this->request->getByType('paymentSystem'))->handlingReturn($this->request->getAllRaw());		
		$this->viewer->assign('ORDER_NUMBER', $resultOfReturn['crmOrderId']);
		$this->viewer->assign('ORDER_URL', 'index.php?module=SSingleOrders&view=DetailView&record=' . $resultOfReturn['crmOrderId']);
		if ('OK' === $resultOfReturn['status']) {
			$tplName = 'PaymentAfterPurchase/PaymentAfterPurchaseStatusOk.tpl';
		} else {
			$tplName = 'PaymentAfterPurchase/PaymentAfterPurchaseStatusError.tpl';
		}
		$this->viewer->view($tplName, $this->request->getModule());
	}
}
