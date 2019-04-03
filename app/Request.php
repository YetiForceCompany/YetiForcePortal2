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
	// Datastore
	private static $request;
	private $valuemap;
	private $defaultmap = [];

	/**
	 * Default constructor.
	 *
	 * @param mixed $values
	 * @param mixed $stripifgpc
	 */
	public function __construct($values, $stripifgpc = true)
	{
		$this->valuemap = $values;
		if ($stripifgpc && !empty($this->valuemap) && get_magic_quotes_gpc()) {
			$this->valuemap = $this->stripslashes_recursive($this->valuemap);
		}
	}

	/**
	 * Strip the slashes recursively on the values.
	 *
	 * @param mixed $value
	 */
	public function stripslashes_recursive($value)
	{
		return is_array($value) ? array_map([$this, 'stripslashes_recursive'], $value) : stripslashes($value);
	}

	/**
	 * Function gets Request object.
	 *
	 * @return Request
	 */
	public static function getInstance()
	{
		if (!static::$request) {
			static::$request = new self($_REQUEST, $_REQUEST);
		}
		return static::$request;
	}

	/**
	 * Set Request instance.
	 *
	 * @param Request $request
	 *
	 * @return Request
	 */
	public static function setInstance(self $request)
	{
		static::$request = $request;
		return static::$request;
	}

	/**
	 * Get data map.
	 */
	public function getAll()
	{
		return $this->valuemap;
	}

	/**
	 * Check for existence of key.
	 *
	 * @param mixed $key
	 */
	public function has($key)
	{
		return isset($this->valuemap[$key]);
	}

	/**
	 * Is the value (linked to key) empty?
	 *
	 * @param mixed $key
	 */
	public function isEmpty($key)
	{
		$value = $this->get($key);
		return empty($value);
	}

	/**
	 * Get key value (otherwise default value).
	 *
	 * @param mixed $key
	 * @param mixed $defvalue
	 */
	public function get($key, $defvalue = '')
	{
		$value = $defvalue;
		if (isset($this->valuemap[$key])) {
			$value = $this->valuemap[$key];
		}
		if ('' === $value && isset($this->defaultmap[$key])) {
			$value = $this->defaultmap[$key];
		}

		$isJSON = false;
		if (is_string($value)) {
			// NOTE: Zend_Json or json_decode gets confused with big-integers (when passed as string)
			// and convert them to ugly exponential format - to overcome this we are performin a pre-check
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

		//Handled for null because vtlib_purify returns empty string
		if (!empty($value)) {
			$value = $this->_cleanInputs($value);
		}
		return $value;
	}

	private function _cleanInputs($data)
	{
		$clean_input = [];
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$clean_input[$k] = $this->_cleanInputs($v);
			}
		} else {
			$clean_input = trim(strip_tags($data));
		}
		return $clean_input;
	}

	/**
	 * Set the value for key.
	 *
	 * @param mixed $key
	 * @param mixed $newvalue
	 */
	public function set($key, $newvalue)
	{
		$this->valuemap[$key] = $newvalue;
	}

	/**
	 * Set default value for key.
	 *
	 * @param mixed $key
	 * @param mixed $defvalue
	 */
	public function setDefault($key, $defvalue)
	{
		$this->defaultmap[$key] = $defvalue;
	}

	/**
	 * Shorthand function to get value for (key=mode).
	 */
	public function getMode()
	{
		return $this->get('mode');
	}

	public function getModule()
	{
		return $this->get('module');
	}

	public function getAction()
	{
		$view = $this->get('view');
		$action = $this->get('action');
		if (!empty($action)) {
			return $action;
		}
		return $view;
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
			throw new \App\Exception\BadRequest();
		}
	}

	public function validateReadAccess()
	{
		if ('GET' !== $_SERVER['REQUEST_METHOD']) {
			throw new \App\Exception\BadRequest();
		}
	}
}
