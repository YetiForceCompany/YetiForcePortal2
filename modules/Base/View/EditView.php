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
		if ($this->request->isEmpty('record')) {
			$recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		} else {
			$recordModel = \YF\Modules\Base\Model\Record::getInstanceById($moduleName, $this->request->getInteger('record'), ['x-raw-data' => 1]);
		}
		$moduleStructure = $recordModel->getModuleModel()->getFieldsFromApi();
		$data = $recordModel->getData();
		$rawData = $recordModel->getRawData();
		$fields = [];
		foreach ($moduleStructure['fields'] as $field) {
			$fieldName = $field['name'];
			if ($field['isEditable']) {
				$fieldInstance = \YF\Modules\Base\Model\Field::getInstance($moduleName, $field);
				if (isset($data[$fieldName])) {
					$fieldInstance->setDisplayValue($data[$fieldName]);
					if (isset($rawData[$fieldName])) {
						$fieldInstance->setRawValue($rawData[$fieldName]);
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
		$this->viewer->assign('BREADCRUMB_TITLE', $recordModel->getName());
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
