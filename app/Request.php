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
	 * Returns raw value from request.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function getRaw(string $key)
	{
		return $this->rawValues[$key] ?? false;
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
	 * @param string     $key          Key name
	 * @param int|string $type         Data type that is only acceptable, default only words 'Standard'
	 * @param mixed      $defaultValue
	 *
	 * @return mixed
	 */
	public function getByType(string $key, $type = 'Standard', $defaultValue = false)
	{
		if (isset($this->purifiedValuesByType[$key][$type])) {
			return $this->purifiedValuesByType[$key][$type];
		}
		if (isset($this->rawValues[$key])) {
			return $this->purifiedValuesByType[$key][$type] = Purifier::purifyByType($this->rawValues[$key], $type);
		}

		return $defaultValue;
	}

	/**
	 * Get integer.
	 *
	 * @param string $key
	 * @param int    $value
	 *
	 * @return int
	 */
	public function getInteger(string $key, int $value = 0): int
	{
		return $this->getByType($key, Purifier::INTEGER, $value);
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
			if ($this->isJSON($value)) {
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
	 * @param string $key
	 * @param mixed  $defvalue
	 *
	 * @return mixed
	 */
	public function get(string $key, $defvalue = '')
	{
		if (isset($this->purifiedValuesByGet[$key])) {
			return $this->purifiedValuesByGet[$key];
		}
		if (!isset($this->rawValues[$key])) {
			return $defvalue;
		}
		$value = $this->rawValues[$key];
		if ($this->isJSON($value)) {
			$decodeValue = Json::decode($value);
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
	 * Check is json.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	private function isJSON($value): bool
	{
		return \is_string($value) && (0 === strpos($value, '[') || 0 === strpos($value, '{'));
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
		return $this->getByType('module', Purifier::ALNUM);
	}

	public function getAction()
	{
		if ($this->isEmpty('action')) {
			return $this->getByType('view', Purifier::ALNUM);
		}
		return $this->getByType('action', Purifier::ALNUM);
	}

	public function isAjax(): bool
	{
		if (!empty($_SERVER['HTTP_X_PJAX']) && true === $_SERVER['HTTP_X_PJAX']) {
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
			throw new \App\Exceptions\BadRequest('ERR_BAD_REQUEST');
		}
		if (class_exists('CSRFConfig') && !\CsrfMagic\Csrf::check(false)) {
			throw new \App\Exceptions\BadRequest('ERR_BAD_REQUEST');
		}
	}

	public function validateReadAccess()
	{
		if ('GET' !== $_SERVER['REQUEST_METHOD']) {
			throw new \App\Exceptions\BadRequest('ERR_BAD_REQUEST');
		}
	}
}
