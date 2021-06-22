<?php
/**
 * Base detail view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App\Purifier;
use YF\Modules\Base\Model\DetailView as DetailViewModel;
use YF\Modules\Base\Model\InventoryField;

/**
 * Base detail view class.
 */
class DetailView extends \App\Controller\View
{
	use \App\Controller\ExposeMethodTrait;

	/** @var \YF\Modules\Base\Model\Record Record model instance. */
	protected $recordModel;

	/** @var \YF\Modules\Base\Model\DetailView Record view model. */
	protected $detailViewModel;

	/** {@inheritdoc} */
	public function __construct(\App\Request $request)
	{
		parent::__construct($request);
		$this->exposeMethod('details');
		$this->exposeMethod('summary');
		$this->exposeMethod('comments');
		$this->exposeMethod('updates');
		$this->exposeMethod('relatedList');
	}

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$this->recordModel = \YF\Modules\Base\Model\Record::getInstanceById($this->request->getModule(), $this->request->getInteger('record'), [
			'x-header-fields' => 1,
		]);
	}

	/** {@inheritdoc} */
	public function process()
	{
		$mode = $this->request->getMode() ?: 'details';
		$this->detailViewModel = DetailViewModel::getInstance($this->recordModel->getModuleName());
		$this->detailViewModel->setRecordModel($this->recordModel);

		$this->loadHeader();
		$this->invokeExposedMethod($mode);
	}

	/**
	 * Gets header.
	 *
	 * @return void
	 */
	public function loadHeader()
	{
		$moduleName = $this->request->getModule();
		$fieldsForm = $fields = [];
		$moduleModel = $this->recordModel->getModuleModel();
		$moduleStructure = $moduleModel->getFieldsFromApi();
		foreach ($moduleStructure['fields'] as $field) {
			$fieldModel = $moduleModel->getFieldModel($field['name']);
			if ($field['isViewable']) {
				$fieldsForm[$field['blockId']][$fieldModel->getName()] = $fieldModel;
			}
			$fields[$field['name']] = $fieldModel;
		}
		$this->viewer->assign('RECORD', $this->recordModel);
		$this->viewer->assign('FIELDS', $fields);
		$this->viewer->assign('FIELDS_FORM', $fieldsForm);
		$this->viewer->assign('FIELDS_HEADER', $this->recordModel->getCustomData()['headerFields'] ?? []);
		$this->viewer->assign('DETAIL_LINKS', $this->detailViewModel->getLinksHeader());
		$this->viewer->assign('BREADCRUMB_TITLE', $this->recordModel->getName());
		$this->viewer->assign('TABS_GROUP', $this->detailViewModel->getTabsFromApi());
		$this->viewer->assign('MENU_ID', $this->request->has('tabId') ? $this->request->getByType('tabId', Purifier::ALNUM) : 'details');
		$this->viewer->view('Detail/Header.tpl', $moduleName);
	}

	/**
	 * Details tab.
	 *
	 * @return void
	 */
	public function details(): void
	{
		$moduleName = $this->request->getModule();
		$moduleStructure = $this->recordModel->getModuleModel()->getFieldsFromApi();
		$inventoryFields = [];
		if (!empty($moduleStructure['inventory'])) {
			$columns = \Conf\Inventory::$columnsByModule[$moduleName] ?? \Conf\Inventory::$columns ?? [];
			$columnsIsActive = !empty($columns);
			foreach ($moduleStructure['inventory'] as $fieldType => $fieldsInventory) {
				if (1 === $fieldType) {
					foreach ($fieldsInventory as $field) {
						if ($field['isVisibleInDetail'] && (!$columnsIsActive || \in_array($field['columnname'], $columns))) {
							$inventoryFields[] = InventoryField::getInstance($moduleName, $field);
						}
					}
				}
			}
		}
		$this->viewer->assign('BLOCKS', $moduleStructure['blocks']);
		$this->viewer->assign('INVENTORY_FIELDS', $inventoryFields);
		$this->viewer->assign('SHOW_INVENTORY_RIGHT_COLUMN', \Conf\Inventory::$showInventoryRightColumn);
		$this->viewer->assign('RECORD', $this->recordModel);
		$this->viewer->assign('SUMMARY_INVENTORY', $this->recordModel->getInventorySummary());
		$this->viewer->view('Detail/DetailView.tpl', $moduleName);
	}

	/**
	 * Summary tab.
	 *
	 * @return void
	 */
	public function summary()
	{
		$moduleName = $this->request->getModule();
		$widgets = [];
		foreach ($this->detailViewModel->getWidgets() as $widget) {
			if ($scripts = $widget->getScripts()) {
				$widget->setScriptsObject($this->convertScripts($scripts, 'js'));
			}
			$widgets[$widget->get('wcol')][] = $widget;
		}
		$this->viewer->assign('DETAIL_VIEW_WIDGETS', $widgets);
		$this->viewer->view('Detail/Summary.tpl', $moduleName);
	}

	/**
	 * Comments tab.
	 *
	 * @return void
	 */
	public function comments()
	{
		// TODO add data
	}

	/**
	 * Updates tab.
	 *
	 * @return void
	 */
	public function updates()
	{
		$moduleName = $this->request->getModule();
		$recordHistory = \YF\Modules\Base\Model\RecordHistory::getInstanceById($moduleName, $this->recordModel->getId());
		$this->viewer->assign('HISTORY_MODEL', $recordHistory);
		$this->viewer->view('Detail/History.tpl', $moduleName);
	}

	/**
	 * Related list tab.
	 *
	 * @return void
	 */
	public function relatedList()
	{
		$relatedListModel = \YF\Modules\Base\Model\RelatedList::getInstance($this->moduleName, 'RelatedList');
		$relatedListModel->setViewModel($this->detailViewModel);
		$relatedListModel->setRequest($this->request);
		$this->viewer->assign('HEADERS', $relatedListModel->getHeaders());
		$this->viewer->assign('RELATION_ID', $this->request->getInteger('relationId'));
		$this->viewer->assign('RELATED_MODULE_NAME', $this->request->getByType('relatedModuleName', Purifier::ALNUM));
		$this->viewer->view('Detail/RelatedList.tpl', $this->request->getModule());
	}
}
