<?php

/**
 * Trait edit/create view method controller file.
 *
 * @package   Controller
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

/**
 * Trait edit/create view method controller class.
 */
trait EditViewTrait
{
	/** @var \YF\Modules\Base\Model\Record Record model instance */
	protected $recordModel;

	/** @var array Hidden fields */
	protected $hiddenFields = [];

	/** @var string Action name */
	protected $actionName;

	/**
	 * Check permission.
	 *
	 * @throws \App\Exceptions\NoPermitted
	 *
	 * @return void
	 */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$this->actionName = 'EditView';
		if ($this->request->isEmpty('record')) {
			$this->actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), $this->actionName)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/**
	 * Main process method.
	 *
	 * @return void
	 */
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
			if ($fieldModel->isEditable($this->actionName)) {
				$fieldModel->set('fieldvalue', $this->recordModel->getRawValue($fieldModel->getName()));
				$structure[$fieldModel->get('blockId')][$fieldModel->getName()] = $fieldModel;
			}
		}
		$this->viewer->assign('VIEW_CONTROLLER', $this);
		$this->viewer->assign('RECORD', $this->recordModel);
		$this->viewer->assign('FIELDS', $moduleModel->getFieldsModels());
		$this->viewer->assign('FIELDS_FORM', $structure);
		$this->viewer->assign('BLOCKS', $moduleModel->getBlocks());
		$this->viewer->assign('BREADCRUMB_TITLE', $this->recordModel->getName());
		$this->loadCustomData();
		$this->viewer->view($this->processTplName(), $moduleName);
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
		} elseif ($this->request->has('sourceRecordData')) {
			$this->hiddenFields = $this->recordModel->loadSourceBasedData([
				'sourceRecordData' => $this->request->getRaw('sourceRecordData'),
			]);
		}
		foreach ($this->recordModel->getModuleModel()->getFieldsModels() as $fieldModel) {
			if ($fieldModel->isEditableHidden()) {
				$fieldModel->set('fieldvalue', $this->recordModel->getRawValue($fieldModel->getName()));
				$value = $fieldModel->getEditViewDisplayValue($this->recordModel);
				$this->hiddenFields[$fieldModel->getName()] = \is_array($value) ? ($value['raw'] ?? '') : $value;
			}
		}
	}

	/**
	 * Get hidden fields.
	 *
	 * @return array
	 */
	public function getHiddenFields(): array
	{
		return $this->hiddenFields;
	}

	/**
	 * Get action name.
	 *
	 * @return array
	 */
	public function getActionName(): string
	{
		return $this->actionName;
	}
}
