<?php
/**
 * Basic record model file.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Basic record model class.
 */
class Record extends \App\BaseModel
{
	/** @var string Record ID. */
	protected $id;

	/** @var string Record name. */
	protected $name = '';

	/** @var string Module name. */
	protected $moduleName;

	/** @var array Information about inventory. */
	protected $inventoryData = [];

	/** @var array Information about summary inventory. */
	protected $inventorySummaryData = [];

	/** @var string Privileges. */
	protected $privileges = [];

	/** @var array Custom data. */
	protected $customData = [];

	/** @var \YF\Modules\Base\Model\Module Module model instance. */
	protected $moduleModel;

	/**
	 * Static Function to get the instance of a clean Record for the given module name.
	 *
	 * @param string $module
	 *
	 * @return \self
	 */
	public static function getInstance(string $module): self
	{
		$handlerModule = \App\Loader::getModuleClassName($module, 'Model', 'Record');
		$instance = new $handlerModule();
		return $instance->setModuleName($module);
	}

	/**
	 * Static function to get the instance of record.
	 *
	 * @param string $moduleName
	 * @param int    $recordId
	 * @param array  $headers
	 *
	 * @return \self
	 */
	public static function getInstanceById(string $moduleName, int $recordId, array $headers = []): self
	{
		$api = \App\Api::getInstance();
		if ($headers) {
			$api->setCustomHeaders($headers);
		}
		$result = $api->call("{$moduleName}/Record/{$recordId}");
		$instance = self::getInstance($moduleName);
		$instance->setData($result['data'] ?? []);
		$instance->setInventoryData($result['inventory'] ?? [], $result['summaryInventory'] ?? []);
		$instance->setPrivileges($result['privileges'] ?? []);
		$instance->name = $result['name'] ?? '';
		unset($result['data'], $result['inventory'], $result['summaryInventory'], $result['privileges'], $result['name']);
		$instance->customData = $result;
		$instance->setId($recordId);
		return $instance;
	}

	/**
	 * Sets information about inventory.
	 *
	 * @param array $values
	 * @param array $summary
	 *
	 * @return void
	 */
	public function setInventoryData(array $values, array $summary = [])
	{
		$this->inventoryData = $values;
		$this->inventorySummaryData = $summary;
	}

	/**
	 * Returns information about inventory.
	 *
	 * @return void
	 */
	public function getInventoryData()
	{
		return $this->inventoryData;
	}

	/**
	 * Returns information about summary inventory.
	 *
	 * @return void
	 */
	public function getInventorySummary()
	{
		return $this->inventorySummaryData;
	}

	public function isInventory()
	{
		return !empty($this->inventoryData);
	}

	/**
	 * Function to get the id of the record.
	 *
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}

	/**
	 * Function to set the id of the record.
	 *
	 * @param int $value
	 *
	 * @return self
	 */
	public function setId(int $value): self
	{
		$this->id = $value;
		return $this;
	}

	/**
	 * Function to get the raw value.
	 *
	 * @return array
	 */
	public function getRawData(): array
	{
		return $this->customData['rawData'] ?? [];
	}

	/**
	 * Set raw data.
	 *
	 * @param array $rawData
	 *
	 * @return self
	 */
	public function setRawData(array $rawData): self
	{
		$this->customData['rawData'] = $rawData;
		return $this;
	}

	/**
	 * Function to get the raw value for a given key.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function getRawValue(string $key)
	{
		return $this->customData['rawData'][$key] ?? '';
	}

	/**
	 * Function to set the raw value for a given key.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return self
	 */
	public function setRawValue(string $key, $value): self
	{
		$this->customData['rawData'][$key] = $value;
		return $this;
	}

	/**
	 * Function to get the name of the module to which the record belongs.
	 *
	 * @return string - Record Module Name
	 */
	public function getModuleName(): string
	{
		return $this->moduleName;
	}

	/**
	 * Get record module model instance.
	 *
	 * @return \YF\Modules\Base\Model\Module - Record module model instance
	 */
	public function getModuleModel(): Module
	{
		return $this->moduleModel;
	}

	/**
	 * Set record name.
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function setName(string $name)
	{
		return $this->name = $name;
	}

	/**
	 * Record name.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get custom data.
	 *
	 * @return array
	 */
	public function getCustomData(): array
	{
		return $this->customData;
	}

	/**
	 * Set privileges.
	 *
	 * @param bool[] $privileges
	 *
	 * @return self
	 */
	public function setPrivileges(array $privileges): self
	{
		$this->privileges = $privileges;
		return $this;
	}

	/**
	 * Function to get the raw value for a given key.
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	public function getDisplayValue(string $key): string
	{
		return !\in_array($key, $this->getModuleModel()->getFieldNames()) ? \App\Purifier::encodeHtml($this->get($key)) : $this->getModuleModel()->getFieldModel($key)->getDisplayValue($this->get($key), $this);
	}

	/**
	 * Get list display value.
	 *
	 * @param string $key
	 *
	 * @return string
	 */
	public function getListDisplayValue(string $key): string
	{
		$fieldModel = $this->getModuleModel()->getFieldModel($key);
		$value = '';
		if ($fieldModel->isViewable()) {
			$value = $fieldModel->getListDisplayValue($this->get($key), $this);
		}
		return $value;
	}

	/**
	 * Function to set the name of the module to which the record belongs.
	 *
	 * @param string $moduleName
	 *
	 * @return \self
	 */
	public function setModuleName(string $moduleName): self
	{
		$this->moduleName = $moduleName;
		$this->moduleModel = \YF\Modules\Base\Model\Module::getInstance($moduleName);
		return $this;
	}

	/**
	 * Function checks if there are permissions to preview record.
	 *
	 * @return bool
	 */
	public function isViewable()
	{
		return true;
	}

	/**
	 * Function checks if there are permissions to edit record.
	 *
	 * @return bool
	 */
	public function isEditable(): bool
	{
		return $this->privileges['isEditable'];
	}

	/**
	 * Function checks if there are permissions to delete record.
	 *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		return $this->privileges['moveToTrash'];
	}

	/**
	 * Function checks permissions to action.
	 *
	 * @param string $actionName
	 *
	 * @return bool
	 */
	public function isPermitted(string $actionName): bool
	{
		return $this->privileges[$actionName];
	}

	/**
	 * Function to get the list view actions for the record.
	 *
	 * @return string
	 */
	public function getListViewActions(): string
	{
		$recordLinks = [];
		if ($this->isViewable()) {
			$recordLinks[] = [
				'label' => 'LBL_SHOW_COMPLETE_DETAILS',
				'moduleName' => $this->getModuleName(),
				'href' => $this->getDetailViewUrl(),
				'icon' => 'fas fa-th-list',
				'class' => 'btn-sm btn-info active js-popover-tooltip js-detail-view',
			];
		}
		if ($this->isEditable()) {
			$recordLinks[] = [
				'label' => 'BTN_EDIT',
				'moduleName' => $this->getModuleName(),
				'href' => $this->getEditViewUrl(),
				'icon' => 'fas fa-edit',
				'class' => 'btn-sm btn-success active js-popover-tooltip',
			];
		}
		if ($this->isDeletable()) {
			$recordLinks[] = [
				'label' => 'LBL_DELETE',
				'moduleName' => $this->getModuleName(),
				'data' => ['url' => $this->getDeleteUrl()],
				'icon' => 'fas fa-trash-alt',
				'class' => 'btn-sm btn-danger active js-delete-record js-popover-tooltip',
			];
		}
		return '<span class="js-record-data" data-id="' . $this->getId() . '"></span>' . \App\Layout\Action::getListViewActions($recordLinks);
	}

	/**
	 * Function to get the list view actions for the record.
	 *
	 * @return string
	 */
	public function getRelatedListActions(): string
	{
		$recordLinks = [];
		if ($this->isViewable()) {
			$recordLinks[] = [
				'label' => 'LBL_SHOW_COMPLETE_DETAILS',
				'moduleName' => $this->getModuleName(),
				'href' => $this->getDetailViewUrl(),
				'icon' => 'fas fa-th-list',
				'class' => 'btn-sm btn-info active js-popover-tooltip',
			];
		}
		if ($this->isEditable()) {
			$recordLinks[] = [
				'label' => 'BTN_EDIT',
				'moduleName' => $this->getModuleName(),
				'href' => $this->getEditViewUrl(),
				'icon' => 'fas fa-edit',
				'class' => 'btn-sm btn-success active js-popover-tooltip',
			];
		}
		return \App\Layout\Action::getListViewActions($recordLinks);
	}

	/**
	 * Function to get the Detail View url for the record.
	 *
	 * @return string - Record Detail View Url
	 */
	public function getDetailViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=DetailView&record=' . $this->getId();
	}

	/**
	 * Function to get the Edit View url for the record.
	 *
	 * @return string - Record Edit View Url
	 */
	public function getEditViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=EditView&record=' . $this->getId();
	}

	/**
	 * Function to get the delete action url for the record.
	 *
	 * @return string
	 */
	public function getDeleteUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&action=Delete&record=' . $this->getId();
	}

	/**
	 * Get fields and blocks.
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function loadSourceBasedData(array $data): array
	{
		$moduleModel = $this->getModuleModel();
		$source = $moduleModel->loadSourceBasedData($data);
		foreach ($source['fieldsForm'] as $fieldName => $value) {
			$this->set($fieldName, $value);
			$this->setRawValue($fieldName, $source['rawData'][$fieldName]);
			$moduleModel->getFieldModel($fieldName)->set('defaultvalue', $value);
		}
		$hiddenFields = [];
		foreach ($source['hiddenFields'] as $fieldName => $value) {
			$this->set($fieldName, $value);
			$hiddenFields[$fieldName] = $value;
		}
		return $hiddenFields;
	}
}
