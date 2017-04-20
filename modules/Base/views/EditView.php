<?php
/**
 * Edit view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;

use Core\Request;
use Core\Api;

class EditView extends Index
{

	/**
	 * Process
	 * @param \Request $request
	 */
	public function process(Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$api = Api::getInstance();
		$moduleStructure = $api->call($module . '/Fields');
		$recordDetail = $api->setCustomHeaders(['X-RAW-DATA' => 1])->call("$module/Record/$record", [], 'get');
		$recordModel = \Base\Model\Record::getInstance($module);
		$recordModel->setData($recordDetail['data'])->setRawData($recordDetail['rawData'])->setId($recordDetail['id']);
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isEditable']) {
				$fieldInstance = \Base\Model\Field::getInstance($module);
				$fields[$field['blockId']][] = $fieldInstance->setData($field);
			}
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('FIELDS', $fields);
		$viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$viewer->view('EditView.tpl', $module);
	}

	/**
	 * Scripts
	 * @param \Core\Request $request
	 * @return \Core\Script[]
	 */
	public function getFooterScripts(\Core\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = [
			'layouts/' . \Core\Viewer::getLayoutName() . "/modules/Base/resources/ListView.js",
			'layouts/' . \Core\Viewer::getLayoutName() . "/modules/$moduleName/resources/ListView.js",
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
