<?php
/**
 * Edit view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App\Api;
use App\Request;

class EditView extends Index
{
	/**
	 * Process.
	 *
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
		$recordModel->setData($recordDetail);

		$moduleStructure = $api->call($moduleName . '/Fields');
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			if ($field['isEditable']) {
				$fieldInstance = \YF\Modules\Base\Model\Field::getInstance($moduleName, $field);
				if (isset($recordDetail['data'][$field['name']])) {
					$fieldInstance->setDisplayValue($recordDetail['data'][$field['name']]);
					if (isset($recordDetail['rawData'][$field['name']])) {
						$fieldInstance->setRawValue($recordDetail['rawData'][$field['name']]);
					}
				} else {
					$fieldInstance->setIsNewRecord();
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
	 * Scripts.
	 *
	 * @param \App\Request $request
	 *
	 * @return \App\Script[]
	 */
	public function getFooterScripts(\App\Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = [
			'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js',
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
