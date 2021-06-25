<?php
/**
 * Basic module model class.
 *
 * @package Model
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App;
use App\Api;

class Module
{
	/** @var YF\Modules\Base\Model\Module[] Module model cache. */
	protected static $cache;

	/** @var string Module name. */
	protected $moduleName;

	/** @var array Fields. */
	protected $fields = [];

	/** @var array Fields. */
	protected $fieldsForm;

	/** @var array Data from API fields. */
	protected $apiFields;

	/** @var array Fields models. */
	protected $fieldsModels;

	protected $defaultView = 'ListView';

	/**
	 * Get module model instance.
	 *
	 * @param string $moduleName
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName): self
	{
		if (isset(self::$cache[$moduleName])) {
			return self::$cache[$moduleName];
		}
		$handlerModule = App\Loader::getModuleClassName($moduleName, 'Model', 'Module');
		return self::$cache[$moduleName] = new $handlerModule($moduleName);
	}

	/**
	 * Constructor  function.
	 *
	 * @param string $moduleName
	 */
	public function __construct(string $moduleName)
	{
		$this->moduleName = $moduleName;
	}

	/**
	 * Function to check permission for a Module/Action.
	 *
	 * @param string $module
	 * @param string $action
	 *
	 * @return bool
	 */
	public static function isPermittedByModule(string $module, string $action)
	{
		if (!\App\Session::has('modulePermissions')) {
			\App\Session::set('modulePermissions', []);
		}
		$data = \App\Session::get('modulePermissions');
		if (!isset($data[$module])) {
			$data[$module] = Api::getInstance()->call($module . '/Privileges');
			\App\Session::set('modulePermissions', $data);
		}
		if (isset($data[$module][$action]) && !empty($data[$module][$action])) {
			return true;
		}
		return false;
	}

	/**
	 * unction to check permission for a Module/Action.
	 *
	 * @param string $action
	 *
	 * @return bool
	 */
	public function isPermitted(string $action): bool
	{
		return self::isPermittedByModule($this->moduleName, $action);
	}

	/**
	 * Get fields and blocks.
	 *
	 * @return array
	 */
	public function loadFieldsFromApi(): void
	{
		if (\App\Cache::has('moduleFields', $this->moduleName)) {
			$data = \App\Cache::get('moduleFields', $this->moduleName);
		} else {
			$data = Api::getInstance()->call($this->moduleName . '/Fields');
			\App\Cache::save('moduleFields', $this->moduleName, $data);
		}
		$this->apiFields = $data;
	}

	/**
	 * Get all blocks.
	 *
	 * @return array
	 */
	public function getBlocks(): array
	{
		if (!isset($this->apiFields['blocks'])) {
			$this->loadFieldsFromApi();
		}
		return $this->apiFields['blocks'];
	}

	/**
	 * Get all fields.
	 *
	 * @return array
	 */
	public function getFields(): array
	{
		if (!isset($this->apiFields['fields'])) {
			$this->loadFieldsFromApi();
		}
		return $this->apiFields['fields'];
	}

	/**
	 * Get inventory fields.
	 *
	 * @return array
	 */
	public function getInventoryFields(): array
	{
		if (!isset($this->apiFields['inventory'])) {
			$this->loadFieldsFromApi();
		}
		return $this->apiFields['inventory'] ?? [];
	}

	/**
	 * Get field by name.
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	public function getField(string $name): array
	{
		if (!isset($this->apiFields['fields'])) {
			$this->loadFieldsFromApi();
		}
		if (empty($this->apiFields['fields'][$name])) {
			throw new \App\Exceptions\AppException("Field not found: {$name}");
		}
		return $this->apiFields['fields'][$name];
	}

	/**
	 * Get field model by name.
	 *
	 * @param string $name
	 *
	 * @return \YF\Modules\Base\FieldTypes\BaseField
	 */
	public function getFieldModel(string $name): \YF\Modules\Base\FieldTypes\BaseField
	{
		if (!isset($this->fieldsModels[$name])) {
			$this->fieldsModels[$name] = Field::getInstance($this->moduleName, $this->getField($name));
		}
		return $this->fieldsModels[$name];
	}

	/**
	 * Get all field names.
	 *
	 * @return string[]
	 */
	public function getFieldNames(): array
	{
		if (!isset($this->apiFields['fields'])) {
			$this->loadFieldsFromApi();
		}
		return array_keys($this->apiFields['fields']);
	}

	/**
	 * Get form fields models.
	 *
	 * @return \YF\Modules\Base\FieldTypes\BaseField[]
	 */
	public function getFormFields(): array
	{
		if (empty($this->fieldsForm)) {
			$this->loadFieldsModels();
		}
		return $this->fieldsForm;
	}

	/**
	 * Get fields models.
	 *
	 * @return \YF\Modules\Base\FieldTypes\BaseField[]
	 */
	public function getFieldsModels(): array
	{
		if (empty($this->fieldsForm)) {
			$this->loadFieldsModels();
		}
		return $this->fieldsModels;
	}

	/**
	 * Load all fields models.
	 *
	 * @return void
	 */
	public function loadFieldsModels(): void
	{
		if (!isset($this->apiFields['fields'])) {
			$this->loadFieldsFromApi();
		}
		$fields = $fieldsForm = [];
		foreach ($this->apiFields['fields'] as $fieldName => $field) {
			$this->fieldsModels[$fieldName] = $fieldInstance = Field::getInstance($this->moduleName, $field);
			if ($field['isEditable']) {
				$fieldsForm[$field['blockId']][$fieldName] = $fieldInstance;
			}
			$fields[$fieldName] = $fieldInstance;
		}
		$this->fieldsModels = $fields;
		$this->fieldsForm = $fieldsForm;
	}

	/**
	 * Get tabs.
	 *
	 * @param int $record
	 *
	 * @return array
	 */
	public function getTabsFromApi(int $record): array
	{
		if (\App\Cache::has('moduleTabs', $this->moduleName)) {
			$data = \App\Cache::get('moduleTabs', $this->moduleName);
		} else {
			$data = Api::getInstance()->call($this->moduleName . '/RelatedModules');
			\App\Cache::save('moduleTabs', $this->moduleName, $data, \App\Cache::LONG);
		}
		$url = "index.php?module={$this->moduleName}&view=DetailView&record={$record}";
		foreach ($data['base'] as &$row) {
			$row['tabId'] = $row['type'];
			$row['url'] = "{$url}&tabId={$row['tabId']}&mode={$row['type']}";
		}
		foreach ($data['related'] as &$row) {
			$row['tabId'] = 'rel' . $row['relationId'];
			$row['url'] = "{$url}&tabId={$row['tabId']}&mode=relatedList&relationId={$row['relationId']}&relatedModuleName={$row['relatedModuleName']}";
		}
		return $data;
	}

	/**
	 * Returns default view for module.
	 *
	 * @return string
	 */
	public function getDefaultView(): string
	{
		return $this->defaultView;
	}

	/**
	 * Returns default address url.
	 *
	 * @return string
	 */
	public function getDefaultUrl(): string
	{
		return "index.php?module={$this->moduleName}&view={$this->getDefaultView()}";
	}

	/**
	 * Function to check is quick create supported.
	 *
	 * @return bool
	 */
	public function isQuickCreateSupported(): bool
	{
		return true;
	}
}
