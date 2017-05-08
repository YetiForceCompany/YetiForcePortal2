<?php
/**
 * Edit view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Base\View;

use YF\Core\Request;
use YF\Core\Api;

class EditView extends Index
{

	/**
	 * Process
	 * @param \Request $request
	 */
	public function process(Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$api = Api::getInstance();

		$recordDetail = $api->setCustomHeaders(['X-RAW-DATA' => 1])->call("$moduleName/Record/$record", [], 'get');
		$recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		if (!isset($recordDetail['data'])) {
			$recordDetail['data'] = [];
		}
		if (!isset($recordDetail['rawData'])) {
			$recordDetail['rawData'] = [];
		}
		if (!isset($recordDetail['id'])) {
			$recordDetail['id'] = null;
		}
		$recordModel->setData($recordDetail['data'])
			->setRawData($recordDetail['rawData'])
			->setId($recordDetail['id']);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isEditable']) {
				$fieldInstance = \YF\Modules\Base\Model\Field::getInstance($moduleName, $field);
				if (isset($recordDetail['data'][$field['name']])) {
					$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
				}
				if (isset($recordDetail['rawData'][$field['name']])) {
					$fieldInstance->setRawValue($recordDetail['rawData'][$field['name']]);
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('FIELDS', $fields);
		$viewer->assign('BREADCRUMB_TITLE', (isset($recordDetail['name'])) ? $recordDetail['name'] : '');
		$viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$viewer->view('EditView.tpl', $moduleName);
	}

	/**
	 * Scripts
	 * @param \YF\Core\Request $request
	 * @return \YF\Core\Script[]
	 */
	public function getFooterScripts(\YF\Core\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = [
			'layouts/' . \YF\Core\Viewer::getLayoutName() . "/modules/Base/resources/EditView.js",
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
