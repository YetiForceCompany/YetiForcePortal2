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

		$recordDetail = $api->call("$moduleName/Record/$record");
		$recordModel = Record::getInstance($moduleName);
		$recordModel->setData($recordDetail['data']);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = Field::getInstance($moduleName, $field);
				if (isset($recordDetail['data'][$field['name']])) {
					if ($field['type'] !== 'multiImage') {
						$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
					}
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$recordModel->setId($record);
		$this->viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->view('Preview/Preview.tpl', $moduleName);
	}
}
