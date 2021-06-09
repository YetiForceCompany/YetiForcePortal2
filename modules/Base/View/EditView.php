<?php
/**
 * Edit view class.
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

class EditView extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission($this->request);
		$actionName = 'EditView';
		if ($this->request->isEmpty('record')) {
			$actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermitted($this->request->getModule(), $actionName)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$api = Api::getInstance();
		$recordDetail = [];
		if (!$this->request->isEmpty('record')) {
			$record = $this->request->getByType('record', Purifier::INTEGER);
			$recordDetail = $api->setCustomHeaders(['x-raw-data' => 1])->call("$moduleName/Record/$record", [], 'get');
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
				} elseif (!empty($field['referenceList']) && 'Accounts' === current($field['referenceList'])) {
					$fieldInstance->setDisplayValue(\App\User::getUser()->get('parentName'));
					$fieldInstance->setRawValue(\App\User::getUser()->get('companyId'));
				} else {
					$fieldInstance->setIsNewRecord();
				}
				$fields[$field['blockId']][] = $fieldInstance;
			}
		}
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('BREADCRUMB_TITLE', (isset($recordDetail['name'])) ? $recordDetail['name'] : '');
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->view('Edit/EditView.tpl', $moduleName);
	}

	/** {@inheritdoc} */
	public function getFooterScripts(bool $loadForModule = true): array
	{
		return array_merge(
			parent::getFooterScripts(),
			$this->convertScripts([
				['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
			], 'js')
		);
	}
}
