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
use App\Purifier;

class EditView extends \App\Controller\View
{
	/**
	 * {@inheritdoc}
	 */
	public function checkPermission(Request $request)
	{
		parent::checkPermission($request);
		$actionName = 'EditView';
		if ($request->isEmpty('record')) {
			$actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermitted($request->getModule(), $actionName)) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
	}

	/**
	 * Process.
	 *
	 * @param \Request $request
	 */
	public function process(Request $request)
	{
		$moduleName = $request->getModule();
		$api = Api::getInstance();

		$recordDetail = [];
		if (!$request->isEmpty('record')) {
			$record = $request->getByType('record', Purifier::INTEGER);
			$recordDetail = $api->setCustomHeaders(['X-RAW-DATA' => 1])->call("$moduleName/Record/$record", [], 'get');
		}
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
	public function getFooterScripts(Request $request)
	{
		$headerScriptInstances = parent::getFooterScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = [
			'layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js',
		];

		$jsScriptInstances = $this->convertScripts($jsFileNames, 'js');
		return array_merge($headerScriptInstances, $jsScriptInstances);
	}
}
