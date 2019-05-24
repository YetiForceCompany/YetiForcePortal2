<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Products\View;

use App\Api;
use App\Purifier;
use YF\Modules\Base\Model\Field;
use YF\Modules\Base\Model\Record;
use YF\Modules\Products\Model\Cart;

class Preview extends \App\Controller\View
{
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$api = Api::getInstance();

		$recordDetail = $api->setCustomHeaders(['X-RAW-DATA' => 1])->call("$moduleName/Record/$record");
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
				if (isset($recordDetail['data'][$field['name']])) {
					if ('multiImage' !== $field['type']) {
						$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
					}
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$tax = current($recordDetail['rawData']['taxes_info']);
		$unitGross = $recordDetail['rawData']['unit_price'];
		if ($tax) {
			$unitGross = $unitGross + ($unitGross * ((float) $tax['value'])) / 100;
		}

		$recordModel->set('unit_gross', $unitGross);
		$recordModel->setId($record);
		$this->viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('FIELDS_LABEL', $recordDetail['fields']);
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->view('Preview/Preview.tpl', $moduleName);
	}
}
