<?php
/**
 * Edit view file.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Edit view class.
 */
class EditView extends \App\Controller\View
{
	/** @var \YF\Modules\Base\Model\Record Record model instance */
	protected $recordModel;

	/** @var array Hidden fields */
	protected $hiddenFields = [];

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$actionName = 'EditView';
		if ($this->request->isEmpty('record')) {
			$actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), $actionName)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		if ($this->request->isEmpty('record')) {
			$this->recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		} else {
			$this->recordModel = \YF\Modules\Base\Model\Record::getInstanceById($moduleName, $this->request->getInteger('record'), ['x-raw-data' => 1]);
		}
		$moduleModel = $this->recordModel->getModuleModel();
		$structure = [];
		foreach ($moduleModel->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isEditable()) {
				$fieldModel->set('fieldvalue', $this->recordModel->getRawValue($fieldModel->getName()));
				$structure[$fieldModel->get('blockId')][$fieldModel->getName()] = $fieldModel;
			}
		}
		$this->viewer->assign('RECORD', $this->recordModel);
		$this->viewer->assign('FIELDS', $moduleModel->getFieldsModels());
		$this->viewer->assign('FIELDS_FORM', $structure);
		$this->viewer->assign('BLOCKS', $moduleModel->getBlocks());
		$this->viewer->assign('BREADCRUMB_TITLE', $this->recordModel->getName());
		$this->loadCustomData();
		$this->viewer->assign('HIDDEN_FIELDS', $this->hiddenFields);
		$this->viewer->view('Edit/EditView.tpl', $moduleName);
	}

	/**
	 * Load relation operation input.
	 *
	 * @return void
	 */
	public function loadCustomData(): void
	{
		if ($this->request->getBoolean('relationOperation')) {
			$relationId = $this->request->getInteger('relationId');
			$sourceModule = $this->request->getByType('sourceModule', \App\Purifier::ALNUM);
			$sourceRecord = $this->request->getInteger('sourceRecord');
			$this->hiddenFields = $this->recordModel->loadSourceBasedData([
				'sourceModule' => $sourceModule,
				'sourceRecord' => $sourceRecord,
			]);
			$this->viewer->assign('RELATION_OPERATION', 'true');
			$this->viewer->assign('RELATION_ID', $relationId);
			$this->viewer->assign('SOURCE_MODULE', $sourceModule);
			$this->viewer->assign('SOURCE_RECORD', $sourceRecord);
		}
		foreach ($this->recordModel->getModuleModel()->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isEditableHidden()) {
				$fieldModel->set('fieldvalue', $this->recordModel->getRawValue($fieldModel->getName()));
				$value = $fieldModel->getEditViewDisplayValue($this->recordModel);
				$this->hiddenFields[$fieldModel->getName()] = \is_array($value) ? ($value['raw'] ?? '') : $value;
			}
		}
	}

	/** {@inheritdoc} */
	public function getFooterScripts(bool $loadForModule = true): array
	{
		$files = [
			['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
		];
		if ($loadForModule) {
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . '/modules/' . $this->getModuleNameFromRequest() . '/resources/EditView.js', true];
		}
		return array_merge(
			parent::getFooterScripts($loadForModule),
			$this->convertScripts($files, 'js')
		);
	}
}
