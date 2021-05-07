<?php
/**
 * Base detail view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App\Api;
use App\Purifier;
use YF\Modules\Base\Model\DetailView as DetailViewModel;
use YF\Modules\Base\Model\Field;
use YF\Modules\Base\Model\InventoryField;
use YF\Modules\Base\Model\Record;

/**
 * Base detail view class.
 */
class DetailView extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$api = Api::getInstance();
		$recordModel = Record::getInstanceById($moduleName, $record);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = Field::getInstance($moduleName, $field);
				if ($recordModel->has($field['name'])) {
					$fieldInstance->setDisplayValue($recordModel->get($field['name']));
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$inventoryFields = [];
		if (!empty($moduleStructure['inventory'])) {
			$columns = \Conf\Inventory::$columnsByModule[$moduleName] ?? \Conf\Inventory::$columns ?? [];
			$columnsIsActive = !empty($columns);
			foreach ($moduleStructure['inventory'] as $fieldType => $fieldsInventory) {
				if (1 === $fieldType) {
					foreach ($fieldsInventory as $field) {
						if ($field['isVisibleInDetail'] && (!$columnsIsActive || \in_array($field['columnname'], $columns))) {
							$inventoryFields[] = InventoryField::getInstance($moduleName, $field);
						}
					}
				}
			}
		}
		$detailViewModel = DetailViewModel::getInstance($moduleName);
		$detailViewModel->setRecordModel($recordModel);
		$this->viewer->assign('BREADCRUMB_TITLE', $recordModel->getName());
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->assign('INVENTORY_FIELDS', $inventoryFields);
		$this->viewer->assign('POSITION_INVENTORY', \Conf\Inventory::$showInventoryColumnRight);
		$this->viewer->assign('SUMMARY_INVENTORY', $recordModel->getInventorySummary());
		$this->viewer->assign('LINKS', $detailViewModel->getLinksHeader());
		$this->viewer->view('Detail/DetailView.tpl', $moduleName);
	}
}
