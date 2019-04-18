<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App\Api;
use App\Purifier;
use YF\Modules\Base\Model\Field;
use YF\Modules\Base\Model\InventoryField;
use YF\Modules\Base\Model\Record;

class DetailView extends \App\Controller\View
{
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$api = Api::getInstance();

		$recordDetail = $api->call("$moduleName/Record/$record");
		$recordModel = Record::getInstance($moduleName);
		$recordModel->setData($recordDetail['data']);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = Field::getInstance($moduleName, $field);
				if (isset($recordDetail['data'][$field['name']])) {
					$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$inventoryFields = [];
		if (!empty($moduleStructure['inventory'])) {
			$recordModel->setInventoryData($recordDetail['inventory']);
			foreach ($moduleStructure['inventory'] as $fieldType => $fieldsInventory) {
				$recordModel->setInventoryData($recordDetail['inventory']);
				if (1 === $fieldType) {
					foreach ($fieldsInventory as $field) {
						if ($field['isVisibleInDetail']) {
							$inventoryFields[] = InventoryField::getInstance($moduleName, $field);
						}
					}
				}
			}
		}
		$this->viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->assign('INVENTORY_FIELDS', $inventoryFields);
		$this->viewer->assign('SUMMARY_INVENTORY', $recordDetail['summary_inventory'] ?? []);
		$this->viewer->view('Detail/DetailView.tpl', $moduleName);
	}
}
