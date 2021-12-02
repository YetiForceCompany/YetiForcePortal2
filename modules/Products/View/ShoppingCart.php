<?php
/**
 * The file contains a class: ShoppingCart.
 *
 * @package   View
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use App\Config;
use App\Purifier;
use YF\Modules\Base\View;
use YF\Modules\Products\Model\CartView;
use YF\Modules\Products\Model\ReferenceCart;

/**
 * Class ShoppingCart.
 */
class ShoppingCart extends View\ListView
{
	const CUSTOM_FIELDS = [
		'productname',
		'product_no',
		'ean',
		'category_multipicklist',
		'productcode',
		'unit_price',
		'taxes',
		'imagename',
		'description',
	];

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		if (!\Conf\Modules\Products::$shoppingMode) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$this->page = $this->request->getInteger('page', 1);
		$offset = ($this->page - 1) * (\App\Config::$itemsPrePage ?: 15);
		$moduleName = $this->request->getModule();
		$listViewModel = $this->getListViewModel()
			->setRawData(true)
			->setFields(static::CUSTOM_FIELDS)
			->setPage($this->page)
			->setOffset($offset);
		$proceedUrl = 'index.php?module=Products&view=ProceedToCheckout';
		$readonly = false;
		if (!$this->request->isEmpty('reference_id')) {
			$readonly = true;
			$listViewModel->setCart(new ReferenceCart($this->request->getInteger('reference_id'), $this->request->getByType('reference_module', Purifier::ALNUM)));
			$proceedUrl .= '&reference_id=' . $this->request->getInteger('reference_id') . '&reference_module=' . $this->request->getByType('reference_module', Purifier::ALNUM);
		}
		$payments = [];
		foreach (Config::get('paymentType') as $paymentType) {
			$payments[] = \App\Payments::getInstance($paymentType);
		}
		$listViewModel->loadRecordsList();
		$this->viewer->assign('RECORDS', $this->getListViewModel()->getRecordsListModel());
		$this->viewer->assign('COUNT', $this->getListViewModel()->getCount());
		$this->viewer->assign('LIST_VIEW_MODEL', $this->getListViewModel());
		$this->viewer->assign('TOTAL_PRICE', $this->getListViewModel()->calculateTotalPriceNetto());
		$this->viewer->assign('TOTAL_PRICE_GROSS', $this->getListViewModel()->calculateTotalPriceGross());
		$this->viewer->assign('ADDRESSES', $this->getListViewModel()->getAddresses());
		$this->viewer->assign('SELECTED_ADDRESS', $this->getListViewModel()->getSelectedAddress());
		$this->viewer->assign('PROCCED_URL', $proceedUrl);
		$this->viewer->assign('READONLY', $readonly);
		$this->viewer->assign('CHECK_STOCK_LEVELS', \App\User::getUser()->get('companyDetails')['check_stock_levels'] ?? false);
		$this->viewer->assign('PAYMENTS', $payments);
		$this->viewer->assign('SHIPPING_PRICE', $this->getListViewModel()->getShippingPrice());
		$this->viewer->assign('ATTENTION', $this->getListViewModel()->getAttention());
		$this->viewer->assign('SELECTED_PAYMENTS', $this->getListViewModel()->getSelectedPayment());
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/** {@inheritdoc} */
	public function getFooterScripts(bool $loadForModule = true): array
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		return array_merge(
			parent::getFooterScripts(false),
			$this->convertScripts([
				['layouts/' . \App\Viewer::getLayoutName() . '/modules/Products/resources/Tree.js'],
				['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js", true],
			], 'js'),
		);
	}

	/** {@inheritdoc} */
	protected function getListViewModel(): \YF\Modules\Base\Model\ListView
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = CartView::getInstance($this->moduleName, 'CartView');
		}
		return $this->listViewModel;
	}

	/** {@inheritdoc} */
	protected function processTplName(): string
	{
		return 'ShoppingCart/ShoppingCart.tpl';
	}

	/** {@inheritdoc} */
	protected function preProcessTplName(): string
	{
		return 'Tree/TreePreProcess.tpl';
	}

	/** {@inheritdoc} */
	protected function postProcessTplName(): string
	{
		return 'Tree/TreePostProcess.tpl';
	}
}
