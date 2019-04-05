<?php
/**
 * ListView model class.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * ListView class.
 */
class ListView
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
	private $recordsList = [];

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
	 * Undocumented variable.
	 *
	 * @var int
	 */
	private $page = 0;

	private $itemsPrePage = 10;

	/**
	 * Conditions.
	 *
	 * @var array
	 */
	private $conditions = [];

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
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName): self
	{
		$handlerModule = \App\Loader::getModuleClassName($moduleName, 'Model', 'ListView');
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

	public function setPage(int $page): self
	{
		$this->page = $page;
		$this->offset = $this->limit * ($page - 1);
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

	public function getPage(): int
	{
		return $this->page;
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
		if (!empty($headers)) {
			$api->setCustomHeaders($headers);
		}
		$this->recordsList = $api->call($this->getModuleName() . '/RecordsList');
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

	public function getNumberOfPages(): int
	{
		return (int) \ceil($this->getCount() / $this->itemsPrePage);
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
