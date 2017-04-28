<?php
/**
 * List view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\View;

use Core;

class DetailView extends Index
{

	/**
	 * Process
	 * @param \Core\Request $request
	 */
	public function process(Core\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$api = Core\Api::getInstance();
		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isViewable']) {
				$fieldInstance = \Base\Model\Field::getInstance($moduleName);
				$fields[$field['blockId']][] = $fieldInstance->setData($field);
			}
		}
		$recordDetail = $api->call("$moduleName/Record/$record");
		$recordModel = \Base\Model\Record::getInstance($moduleName);
		$recordModel->setData($recordDetail['data'])->setId($recordDetail['id']);
		$viewer = $this->getViewer($request);
		$viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('FIELDS', $fields);
		$viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$viewer->view('DetailView.tpl', $moduleName);
	}
}
