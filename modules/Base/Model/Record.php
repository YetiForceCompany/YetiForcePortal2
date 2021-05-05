<?php
/**
 * Basic record model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

class Record extends \App\BaseModel
{
	/**
	 * Module name.
	 *
	 * @var string
	 */
	private $module;

	/**
	 * Record name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Privileges.
	 *
	 * @var array
	 */
	protected $privileges = [];

	/**
	 * 	Information about inventory.
	 *
	 * @var array
	 */
	private $inventoryData = [];

	/**
	 * 	Information about summary inventory.
	 *
	 * @var array
	 */
	private $inventorySummaryData = [];

	/**
	 * Static Function to get the instance of a clean Record for the given module name.
	 *
	 * @param string $module
	 *
	 * @return \self
	 */
	public static function getInstance(string $module)
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
	 *
	 * @return \self
	 */
	public static function getInstanceById(string $moduleName, int $recordId)
	{
		$result = \App\Api::getInstance()->call("{$moduleName}/Record/{$recordId}");
		$instance = self::getInstance($moduleName);
		$instance->setData($result['data'] ?? []);
		$instance->setInventoryData($result['inventory'] ?? [], $result['summaryInventory'] ?? []);
		$instance->privileges = $result['privileges'] ?? [];
		$instance->name = $result['name'] ?? '';
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
	 * Function to set the id of the record.
	 *
	 * @param \self
	 * @param mixed $value
	 */
	public function setId($value)
	{
		return $this->set('id', $value);
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
		return \App\Purifier::encodeHtml((string) $this->get($key));
	}

	/**
	 * Function to get the raw value.
	 *
	 * @return array
	 */
	public function getRawData(): array
	{
		return $this->valueMap['rawData'] ?? [];
	}

	/**
	 * Set raw data.
	 *
	 * @param array $rawData
	 *
	 * @return void
	 */
	public function setRawData(array $rawData)
	{
		$this->valueMap['rawData'] = $rawData;
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
		return $this->valueMap['rawData'][$key] ?? '';
	}

	/**
	 * Function to set the raw value for a given key.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return self
	 */
	public function setRawValue(string $key, $value)
	{
		$this->valueMap['rawData'][$key] = $value;
		return $this;
	}

	/**
	 * Function to set the name of the module to which the record belongs.
	 *
	 * @param string $value
	 *
	 * @return \self
	 */
	public function setModuleName($value)
	{
		$this->module = $value;
		return $this;
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
	 * Function to get the list view actions for the record.
	 *
	 * @return array
	 */
	public function getRecordListViewActions()
	{
		$recordLinks = [];
		if ($this->isViewable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'LBL_SHOW_COMPLETE_DETAILS',
				'linkurl' => $this->getDetailViewUrl(),
				'linkicon' => 'fas fa-th-list',
				'linkclass' => 'btn-sm btn-info active detailLink'
			];
		}
		if ($this->isEditable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'BTN_EDIT',
				'linkurl' => $this->getEditViewUrl(),
				'linkicon' => 'fas fa-edit',
				'linkclass' => 'btn-sm btn-success active'
			];
		}
		if ($this->isDeletable()) {
			$recordLinks[] = [
				'linktype' => 'LIST_VIEW_ACTIONS_RECORD_LEFT_SIDE',
				'linklabel' => 'LBL_DELETE',
				'linkdata' => ['url' => $this->getDeleteUrl()],
				'linkicon' => 'fas fa-trash-alt',
				'linkclass' => 'btn-sm btn-danger active deleteRecordButton'
			];
		}
		return $recordLinks;
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
	 * Function to get the Detail View url for the record.
	 *
	 * @return string - Record Detail View Url
	 */
	public function getDetailViewUrl()
	{
		return 'index.php?module=' . $this->getModuleName() . '&view=DetailView&record=' . $this->getId();
	}

	/**
	 * Function to get the name of the module to which the record belongs.
	 *
	 * @return string - Record Module Name
	 */
	public function getModuleName()
	{
		return $this->module;
	}

	/**
	 * Function to get the id of the record.
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->get('id');
	}

	/**
	 * Function checks if there are permissions to edit record.
	 *
	 * @return bool
	 */
	public function isEditable(): bool
	{
		if (!isset($this->privileges['isEditable'])) {
			$this->privileges['isEditable'] = \YF\Modules\Base\Model\Module::isPermitted($this->getModuleName(), 'EditView', $this->getId());
		}
		return $this->privileges['isEditable'];
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
	 * Function checks if there are permissions to delete record.
	 *
	 * @return bool
	 */
	public function isDeletable(): bool
	{
		if (!isset($this->privileges['moveToTrash'])) {
			$this->privileges['moveToTrash'] = \YF\Modules\Base\Model\Module::isPermitted($this->getModuleName(), 'MoveToTrash', $this->getId());
		}
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
		if (!isset($this->privileges[$actionName])) {
			$this->privileges[$actionName] = \YF\Modules\Base\Model\Module::isPermitted($this->getModuleName(), $actionName, $this->getId());
		}
		return $this->privileges[$actionName];
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
}
