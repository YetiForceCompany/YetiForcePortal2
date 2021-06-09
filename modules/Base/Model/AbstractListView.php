<?php
/**
 * The file contains: Abstract class ListView.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Abstract class ListView.
 */
abstract class AbstractListView
{
	/** @var string Module name. */
	protected $moduleName;

	/** @var string[] Column fields */
	protected $fields = [];

	/** @var array Records list from api. */
	protected $recordsList = [];

	/** @var int Current page. */
	private $page = 1;

	/** @var int The number of items on the page. */
	protected $limit = 0;

	/** @var int Offset. */
	protected $offset = 0;

	/** @var string Sorting direction. */
	protected $order;

	/** @var string Sets the ORDER BY part of the query record list. */
	protected $orderField;

	/** @var array Conditions. */
	protected $conditions = [];

	/** @var bool Use raw data. */
	protected $rawData = false;

	protected $actionName = 'RecordsList';

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
		$self = new $handlerModule();
		$self->moduleName = $moduleName;
		$self->limit = \App\Config::$itemsPrePage ?: 15;
		return $self;
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
	public function setFields(array $fields): self
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
	 * Set offset.
	 *
	 * @param int $offset
	 *
	 * @return self
	 */
	public function setOffset(int $offset): self
	{
		$this->offset = $offset;
		return $this;
	}

	/**
	 * Set order.
	 *
	 * @param string $field
	 * @param string $direction
	 *
	 * @return self
	 */
	public function setOrder(string $field, string $direction): self
	{
		$this->orderField = $field;
		$this->order = $direction;
		return $this;
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
		$headers = [
			'x-row-count' => 1,
			'x-row-limit' => $this->limit,
			'x-row-offset' => $this->offset,
		];
		if (!empty($this->fields)) {
			$headers['x-fields'] = \App\Json::encode($this->fields);
		}
		if (!empty($this->conditions)) {
			$headers['x-condition'] = \App\Json::encode($this->conditions);
		}
		if ($this->rawData) {
			$headers['x-raw-data'] = 1;
		}
		if (!empty($this->order)) {
			$headers['x-row-order-field'] = $this->orderField;
			$headers['x-row-order'] = $this->order;
		}
		$this->recordsList = $this->getFromApi($headers);
		return $this;
	}

	/**
	 * Get data from api.
	 *
	 * @param array $headers
	 *
	 * @return array
	 */
	protected function getFromApi(array $headers): array
	{
		$api = \App\Api::getInstance();
		$api->setCustomHeaders($headers);
		return $api->call($this->getModuleName() . '/' . $this->actionName);
	}

	/**
	 * Get records list model.
	 *
	 * @return Record[]
	 */
	public function getRecordsListModel(): array
	{
		$recordsModel = [];
		if (!empty($this->recordsList['records'])) {
			foreach ($this->recordsList['records'] as $id => $value) {
				$recordModel = Record::getInstance($this->getModuleName());
				if (isset($value['recordLabel'])) {
					$recordModel->setName($value['recordLabel']);
					unset($value['recordLabel']);
				}
				$recordModel->setData($value)->setId($id);
				$recordsModel[$id] = $recordModel;
			}
		}
		if (!empty($this->recordsList['rawData'])) {
			foreach ($this->recordsList['rawData'] as $id => $value) {
				$recordsModel[$id]->setRawData($value);
			}
		}
		return $recordsModel;
	}

	/**
	 * Get headers of list.
	 *
	 * @return array
	 */
	public function getHeaders(): array
	{
		if (empty($this->recordsList)) {
			$this->recordsList = $this->getFromApi([
				'x-only-column' => 1,
			]);
		}
		return $this->recordsList['headers'] ?? [];
	}

	/**
	 * Get all rows count.
	 *
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->recordsList['numberOfAllRecords'] ?? 0;
	}

	/**
	 * Get current page.
	 *
	 * @return int
	 */
	public function getPage(): int
	{
		if (!$this->page) {
			$this->page = floor($this->recordsList['numberOfRecords'] / ($this->recordsList['numberOfAllRecords'] ?: 1)) ?: 1;
		}
		return $this->page;
	}

	/**
	 * Sets page number.
	 *
	 * @param int $page
	 *
	 * @return $this
	 */
	public function setPage(int $page)
	{
		$this->page = $page;
		return $this;
	}

	/**
	 * Is there more pages.
	 *
	 * @return bool
	 */
	public function isMorePages(): bool
	{
		return $this->recordsList['isMorePages'] ?? false;
	}
}
