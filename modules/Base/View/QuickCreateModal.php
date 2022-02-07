<?php
/**
 * Quick create view modal file.
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
 * Quick create view modal class.
 */
class QuickCreateModal extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public $showFooter = false;

	/** @var \YF\Modules\Base\Model\Record Record model instance */
	protected $recordModel;

	/** @var array Hidden fields */
	protected $hiddenFields = [];

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), 'CreateView')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	protected function getTitle()
	{
		return \App\Language::translate('LBL_VIEW_QUICK_CREATE', $this->request->getModule()) . ' - ' . \App\Language::translateModule($this->request->getModule());
	}

	/** {@inheritdoc} */
	protected function getModalSize()
	{
		return 'c-modal-xxl';
	}

	/** {@inheritdoc} */
	protected function getModalIcon(): string
	{
		return 'yfm-' . $this->request->getModule();
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$this->recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		$moduleModel = $this->recordModel->getModuleModel();
		$structure = [];
		foreach ($moduleModel->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isEditable()) {
				$structure[$fieldModel->get('blockId')][$fieldModel->getName()] = $fieldModel;
			}
		}
		$this->viewer->assign('RECORD', $this->recordModel);
		$this->viewer->assign('FIELDS', $moduleModel->getFieldsModels());
		$this->viewer->assign('FIELDS_FORM', $structure);
		$this->viewer->assign('BLOCKS', $moduleModel->getBlocks());
		$this->loadCustomData();
		$this->viewer->assign('HIDDEN_FIELDS', $this->hiddenFields);
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/**
	 * Load relation operation input.
	 *
	 * @return void
	 */
	public function loadCustomData(): void
	{
		if ($this->request->has('relationOperation')) {
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
		} elseif ($this->request->has('sourceRecordData')) {
			$this->hiddenFields = $this->recordModel->loadSourceBasedData([
				'sourceRecordData' => $this->request->getRaw('sourceRecordData'),
			]);
		}
		foreach ($this->recordModel->getModuleModel()->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isEditableHidden()) {
				$fieldModel->set('fieldvalue', $this->recordModel->getRawValue($fieldModel->getName()));
				$value = $fieldModel->getEditViewDisplayValue($this->recordModel);
				$this->hiddenFields[$fieldModel->getName()] = \is_array($value) ? $value['raw'] : $value;
			}
		}
	}

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'Modal/QuickCreate.tpl';
	}

	/** {@inheritdoc} */
	public function getModalJs(bool $loadForModule = true): array
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		$files = [
			['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/{$action}.js", true],
		];
		if ($loadForModule) {
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . '/modules/' . $this->getModuleNameFromRequest() . '/resources/EditView.js', true];
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js", true];
		}
		return $this->convertScripts($files, 'js');
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateWriteAccess();
	}
}
