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
	 * Load a list of records from the API.
	 *
	 * @return self
	 */
	public function loadRecordsList(): self
	{
		$api = \App\Api::getInstance();
		if (!empty($this->fields)) {
			$api->setCustomHeaders([
				'x-fields' => \App\Json::encode($this->fields)
			]);
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
}
