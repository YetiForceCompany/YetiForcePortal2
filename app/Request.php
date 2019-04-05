<?php
/**
 * Request class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

class Request
{
	/**
	 * Raw values.
	 *
	 * @var array
	 */
	private $rawValues = [];

	/**
	 * Instance of class.
	 *
	 * @var [type]
	 */
	public static $request;

	private $purifiedValuesByType = [];
	private $purifiedValuesByArray = [];
	private $purifiedValuesByGet = [];

	/**
	 * Default constructor.
	 *
	 * @param array $values
	 */
	public function __construct(array $values)
	{
		$this->rawValues = $values;
		static::$request = $this;
	}

	/**
	 * Function gets Request object.
	 *
	 * @return Request
	 */
	public static function getInstance(): self
	{
		if (!static::$request) {
			static::$request = new self($_REQUEST);
		}
		return static::$request;
	}

	/**
	 * Get data map.
	 */
	public function getAllRaw()
	{
		return $this->rawValues;
	}

	/**
	 * Check for existence of key.
	 *
	 * @param mixed $key
	 */
	public function has($key)
	{
		return isset($this->rawValues[$key]);
	}

	/**
	 * Is the value (linked to key) empty?
	 *
	 * @param mixed $key
	 */
	public function isEmpty($key)
	{
		return empty($this->rawValues[$key]);
	}

	/**
	 * Purify by data type.
	 *
	 * @param string     $key  Key name
	 * @param int|string $type Data type that is only acceptable, default only words 'Standard'
	 *
	 * @return bool|mixed
	 */
	public function getByType($key, $type = 'Standard')
	{
		if (isset($this->purifiedValuesByType[$key][$type])) {
			return $this->purifiedValuesByType[$key][$type];
		}
		if (isset($this->rawValues[$key])) {
			return $this->purifiedValuesByType[$key][$type] = Purifier::purifyByType($this->rawValues[$key], $type);
		}

		return false;
	}

	/**
	 * Function to get the array values for a given key.
	 *
	 * @param string $key
	 * @param string $type
	 * @param array  $value
	 *
	 * @return array
	 */
	public function getArray(string $key, string $type = 'Text', $value = []): array
	{
		if (isset($this->purifiedValuesByArray[$key])) {
			return $this->purifiedValuesByArray[$key];
		}
		if (isset($this->rawValues[$key])) {
			$value = $this->rawValues[$key];
			if (!$value) {
				return [];
			}
			if (is_string($value) && (0 === strpos($value, '[') || 0 === strpos($value, '{'))) {
				$decodeValue = Json::decode($value);
				if (isset($decodeValue)) {
					$value = $decodeValue;
				}
			}
			if ($value) {
				$value = Purifier::purifyByType($value, $type);
			}

			return $this->purifiedValuesByArray[$key] = (array) $value;
		}

		return $value;
	}

	/**
	 * Get key value (otherwise default value).
	 *
	 * @param mixed $key
	 * @param mixed $defvalue
	 */
	public function get($key, $defvalue = '')
	{
		if (isset($this->purifiedValuesByGet[$key])) {
			return $this->purifiedValuesByGet[$key];
		}
		if (!isset($this->rawValues[$key])) {
			return $defvalue;
		}
		$value = $this->rawValues[$key];
		$isJSON = false;
		if (is_string($value)) {
			if (0 === strpos($value, '[') || 0 === strpos($value, '{')) {
				$isJSON = true;
			}
		}
		if ($isJSON) {
			$decodeValue = Json::json_decode($value);
			if (isset($decodeValue)) {
				$value = $decodeValue;
			}
		}
		if (!empty($value)) {
			$value = Purifier::purifyByType($value, Purifier::TEXT);
		}
		$this->purifiedValuesByGet[$key] = $value;
		return $value;
	}

	/**
	 * Set the value for key.
	 *
	 * @param mixed $key
	 * @param mixed $newvalue
	 */
	public function set($key, $newvalue)
	{
		$this->rawValues[$key] = $newvalue;
		$this->purifiedValuesByType[$key] = null;
		$this->purifiedValuesByArray[$key] = null;
		$this->purifiedValuesByGet[$key] = null;
	}

	/**
	 * Shorthand function to get value for (key=mode).
	 */
	public function getMode()
	{
		return $this->getByType('mode', Purifier::ALNUM);
	}

	public function getModule()
	{
		return  $this->getByType('module', Purifier::ALNUM);
	}

	public function getAction()
	{
		if ($this->isEmpty('action')) {
			return $this->getByType('view', Purifier::ALNUM);
		}
		return  $this->getByType('action', Purifier::ALNUM);
	}

	public function isAjax()
	{
		if (!empty($_SERVER['HTTP_X_PJAX']) && true == $_SERVER['HTTP_X_PJAX']) {
			return true;
		}
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
		return false;
	}

	public function validateWriteAccess()
	{
		if ('POST' !== $_SERVER['REQUEST_METHOD']) {
			throw new \App\Exception\BadRequest('ERR_BAD_REQUEST');
		}
	}

	public function validateReadAccess()
	{
		if ('GET' !== $_SERVER['REQUEST_METHOD']) {
			throw new \App\Exception\BadRequest('ERR_BAD_REQUEST');
		}
	}
}
