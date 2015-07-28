<?php
/**
 * Request class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;

class Request
{

	// Datastore
	private $valuemap;
	private $defaultmap = [];

	/**
	 * Default constructor
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
	 */
	public function stripslashes_recursive($value)
	{
		$value = is_array($value) ? array_map(array($this, 'stripslashes_recursive'), $value) : stripslashes($value);
		return $value;
	}

	/**
	 * Get key value (otherwise default value)
	 */
	public function get($key, $defvalue = '')
	{
		$value = $defvalue;
		if (isset($this->valuemap[$key])) {
			$value = $this->valuemap[$key];
		}
		if ($value === '' && isset($this->defaultmap[$key])) {
			$value = $this->defaultmap[$key];
		}

		$isJSON = false;
		if (is_string($value)) {
			// NOTE: Zend_Json or json_decode gets confused with big-integers (when passed as string)
			// and convert them to ugly exponential format - to overcome this we are performin a pre-check
			if (strpos($value, "[") === 0 || strpos($value, "{") === 0) {
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

	/**
	 * Get data map
	 */
	public function getAll()
	{
		return $this->valuemap;
	}

	/**
	 * Check for existence of key
	 */
	public function has($key)
	{
		return isset($this->valuemap[$key]);
	}

	/**
	 * Is the value (linked to key) empty?
	 */
	public function isEmpty($key)
	{
		$value = $this->get($key);
		return empty($value);
	}

	/**
	 * Set the value for key
	 */
	public function set($key, $newvalue)
	{
		$this->valuemap[$key] = $newvalue;
	}

	/**
	 * Set default value for key
	 */
	public function setDefault($key, $defvalue)
	{
		$this->defaultmap[$key] = $defvalue;
	}

	/**
	 * Shorthand function to get value for (key=mode)
	 */
	public function getMode()
	{
		return $this->get('mode');
	}

	public function getModule()
	{
		return $this->get('module');
	}

	function getAction()
	{
		$view = $this->get('view');
		$action = $this->get('action');
		if (!empty($action)) {
			return $action;
		} else {
			return $view;
		}
	}

	public function isAjax()
	{
		if (!empty($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == true) {
			return true;
		} elseif (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
		return false;
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
}
