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
	protected $fields;

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
	public static function isPermitted(string $module, string $action)
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
	 * Get all fields.
	 *
	 * @return array
	 */
	public function getFields(): array
	{
		if (isset($this->fields)) {
			return $this->fields;
		}
		$data = $this->getFieldsFromApi();
		$fields = [];
		foreach ($data['fields'] as $field) {
			$fields[$field['name']] = $field;
		}
		return $this->fields = $fields;
	}

	/**
	 * Get all fields models.
	 *
	 * @return \YF\Modules\Base\FieldTypes\BaseField[]
	 */
	public function getFieldsModels(): array
	{
		$fields = [];
		foreach (array_keys($this->getFields()) as $fieldName) {
			$fields[$fieldName] = $this->getFieldModel($fieldName);
		}
		return $fields;
	}

	/**
	 * Get fields and blocks.
	 *
	 * @return array
	 */
	public function getFieldsFromApi(): array
	{
		if (\App\Cache::has('moduleFields', $this->moduleName)) {
			$data = \App\Cache::get('moduleFields', $this->moduleName);
		} else {
			$data = Api::getInstance()->call($this->moduleName . '/Fields');
			\App\Cache::save('moduleFields', $this->moduleName, $data);
		}
		return $data;
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
		if (empty($this->fields)) {
			$this->getFields();
		}
		if (empty($this->fields[$name])) {
			throw new \App\Exceptions\AppException("Field not found: {$name}");
		}
		return $this->fields[$name];
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
}
