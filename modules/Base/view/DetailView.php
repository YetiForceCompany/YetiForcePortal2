<?php
/**
 * List view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Modules\Base\View;

use YF\Core;

class DetailView extends Index
{

	/**
	 * Process
	 * @param \YF\Core\Request $request
	 */
	public function process(\YF\Core\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$api = \YF\Core\Api::getInstance();
		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = \YF\Modules\Base\Model\Field::getInstance($moduleName);
				$fields[$field['blockId']][] = $fieldInstance->setData($field);
			}
		}
		$recordDetail = $api->call("$moduleName/Record/$record");
		$recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		$recordModel->setData($recordDetail['data'])->setId($recordDetail['id']);
		$viewer = $this->getViewer($request);
		$viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('FIELDS', $fields);
		$viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$viewer->view('DetailView.tpl', $moduleName);
	}
}
