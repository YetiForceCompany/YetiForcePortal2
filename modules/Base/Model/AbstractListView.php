<?php
/**
 * The file contains: Abstract class ListView.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Abstract class ListView.
 */
abstract class AbstractListView
{
	/**
	 * Module name.
	 *
	 * @var string
	 */
	private $moduleName;

	/**
	 * Custom fields.
	 *
	 * @var array
	 */
	private $fields = [];

	/**
	 * Records list from api.
	 *
	 * @var array
	 */
	protected $recordsList = [];

	/**
	 * Limit.
	 *
	 * @var int
	 */
	private $limit = 0;

	/**
	 * Offset.
	 *
	 * @var int
	 */
	private $offset = 0;

	/**
	 * Current page.
	 *
	 * @var int
	 */
	private $page = 1;

	/**
	 * Conditions.
	 *
	 * @var array
	 */
	private $conditions = [];

	/**
	 * Use raw data.
	 *
	 * @var bool
	 */
	private $rawData = false;

	protected $actionName = 'RecordsList';

	/**
	 * Construct.
	 *
	 * @param string $moduleName
	 */
	public function __construct(string $moduleName)
	{
		$this->setModuleName($moduleName);
	}

	/**
	 * Get instance.
	 *
	 * @param string $moduleName
	 * @param string $viewName
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName, string $viewName = 'ListView'): self
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', $viewName);
		return new $handlerModule($moduleName);
	}

	/**
	 * Function to set the name of the module to which the record belongs.
	 *
	 * @param string $value
	 *
	 * @return \self
	 */
	public function setModuleName($value): self
	{
		$this->moduleName = $value;
		return $this;
	}

	/**
	 * Function to get the Module Model.
	 *
	 * @return string
	 */
	public function getModuleName(): string
	{
		return $this->moduleName;
	}

	/**
	 * Function to set raw data.
	 *
	 * @param bool $rawData
	 *
	 * @return self
	 */
	public function setRawData(bool $rawData): self
	{
		$this->rawData = $rawData;
		return $this;
	}

	/**
	 * Set custom fields.
	 *
	 * @param array $fields
	 *
	 * @return self
	 */
	public function setCustomFields(array $fields): self
	{
		$this->fields = $fields;
		return $this;
	}

	/**
	 * Set limit.
	 *
	 * @param int $limit
	 *
	 * @return self
	 */
	public function setLimit(int $limit): self
	{
		$this->limit = $limit;
		return $this;
	}

	/**
	 * Set current page.
	 *
	 * @param int $page
	 *
	 * @return self
	 */
	public function setPage(int $page): self
	{
		$this->page = $page < 1 ? 1 : $page;
		$this->offset = $this->limit * ($this->page - 1);
		return $this;
	}

	/**
	 * Set offsett.
	 *
	 * @param int $offset
	 *
	 * @return self
	 */
	public function setOffsett(int $offset): self
	{
		$this->offset = $offset;
		return $this;
	}

	/**
	 * Get current page.
	 *
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * Set conditions.
	 *
	 * @param array $conditions
	 *
	 * @return void
	 */
	public function setConditions(array $conditions)
	{
		$this->conditions = $conditions;
	}

	/**
	 * Load a list of records from the API.
	 *
	 * @return self
	 */
	public function loadRecordsList(): self
	{
		$api = \App\Api::getInstance();
		$headers = [];
		if (!empty($this->fields)) {
			$headers['x-fields'] = \App\Json::encode($this->fields);
		}
		if (!empty($this->limit)) {
			$headers['x-row-limit'] = $this->limit;
		}
		if (!empty($this->offset)) {
			$headers['x-row-offset'] = $this->offset;
		}
		if (!empty($this->conditions)) {
			$headers['x-condition'] = \App\Json::encode($this->conditions);
		}
		if ($this->rawData) {
			$headers['x-raw-data'] = 1;
		}
		if (!empty($headers)) {
			$api->setCustomHeaders($headers);
		}
		$this->recordsList = $api->call($this->getModuleName() . '/' . $this->actionName);
		return $this;
	}

	/**
	 * Get records list model.
	 *
	 * @return Record[]
	 */
	public function getRecordsListModel(): array
	{
		$recordsListModel = [];
		if (!empty($this->recordsList['records'])) {
			foreach ($this->recordsList['records'] as $key => $value) {
				$recordModel = Record::getInstance($this->getModuleName());
				$recordModel->setData($value)->setId($key);
				$recordsListModel[$key] = $recordModel;
			}
		}
		if (!empty($this->recordsList['rawData'])) {
			foreach ($this->recordsList['rawData'] as $key => $value) {
				$recordsListModel[$key]->setRawData($value);
			}
		}
		return $recordsListModel;
	}

	/**
	 * Get headers of list.
	 *
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->recordsList['headers'] ?? [];
	}

	/**
	 * Get count.
	 *
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->recordsList['count'] ?? 0;
	}

	/**
	 * Get number of pages.
	 *
	 * @return int
	 */
	public function getNumberOfPages(): int
	{
		return (int) \ceil($this->getCount() / Config::getInt('itemsPrePage'));
	}

	/**
	 * Is there more pages.
	 *
	 * @return bool
	 */
	public function isMorePages(): bool
	{
		return $this->recordsList['isMorePages'];
	}
}
