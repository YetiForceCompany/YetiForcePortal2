<?php
/**
 * The file contains: View class for payment after purchase.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use YF\Modules\Base\Model\Record;

/**
 * View class for payment after purchase.
 */
class PaymentAfterPurchase extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function process()
	{
		$paymentSystem = \App\Payments::getInstance($this->request->getByType('paymentSystem'));
		if ($paymentSystem instanceof \App\Payments\PaymentsSystemInterface) {
			$resultOfReturn = $paymentSystem->handlingReturn($this->request->getAllRaw());
		} else {
			$resultOfReturn['crmOrderId'] = $this->request->getInteger('crmOrderId');
			$resultOfReturn['status'] = 'OK';
		}
		$this->viewer->assign('RECORD_MODEL', Record::getInstanceById('SSingleOrders', $resultOfReturn['crmOrderId']));
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
