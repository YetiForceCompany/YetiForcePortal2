<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use App\Api;
use App\Purifier;
use YF\Modules\Base\Model\Field;
use YF\Modules\Base\Model\Record;
use YF\Modules\Products\Model\Cart;

class Preview extends \App\Controller\View
{
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
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$api = Api::getInstance();
		$recordDetail = $api->setCustomHeaders([
			'x-raw-data' => 1,
			'x-product-bundles' => 1,
			'x-unit-price' => 1,
			'x-unit-gross' => 1,
		])->call("$moduleName/Record/$record");
		$recordModel = Record::getInstance($moduleName);
		$recordModel->setData($recordDetail['data']);
		$amountInCart = 0;
		$cart = new Cart();
		if ($cart->has($record)) {
			$amountInCart = $cart->getAmount($record);
		}
		$recordModel->setRawValue('amountInShoppingCart', $amountInCart);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = Field::getInstance($moduleName, $field);
				if (isset($recordDetail['data'][$field['name']]) && 'multiImage' !== $field['type']) {
					$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$recordModel->set('unit_price', \App\Fields\Currency::formatToDisplay($recordDetail['ext']['unit_price']));
		$recordModel->set('unit_gross', \App\Fields\Currency::formatToDisplay($recordDetail['ext']['unit_gross']));
		$recordModel->setRawValue('unit_price', $recordDetail['ext']['unit_price']);
		$recordModel->setRawValue('unit_gross', $recordDetail['ext']['unit_gross']);
		$recordModel->setRawValue('qtyinstock', $recordDetail['ext']['qtyinstock'] ?? 0);
		$recordModel->setId($record);
		$this->viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('FIELDS_LABEL', $recordDetail['fields']);
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->assign('RECORDS', isset($recordDetail['productBundles']) ? $this->getProductBundles($recordDetail['productBundles']) : []);
		$this->viewer->assign('READONLY', false);
		$this->viewer->assign('CHECK_STOCK_LEVELS', \App\User::getUser()->get('companyDetails')['check_stock_levels'] ?? false);
		$this->viewer->view('Preview/Preview.tpl', $moduleName);
	}

	/**
	 * Get product bundles.
	 *
	 * @param array $productBundles
	 *
	 * @return Record[]
	 */
	private function getProductBundles(array $productBundles): array
	{
		$moduleName = $this->request->getModule();
		$products = [];
		foreach ($productBundles as $key => $row) {
			$recordModel = Record::getInstance($moduleName);
			if (isset($value['recordLabel'])) {
				$recordModel->setName($value['recordLabel']);
				unset($value['recordLabel']);
			}
			$recordModel->setData($row['data']);
			$recordModel->setRawData($row['rawData']);
			$products[$key] = $recordModel;
		}
		return $products;
	}
}
