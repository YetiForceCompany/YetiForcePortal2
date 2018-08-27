<?php
/**
 * Base class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Core;

class BaseModel
{
	/**
	 * Record data.
	 *
	 * @var array
	 */
	protected $valueMap = [];

	/**
	 * Constructor.
	 *
	 * @param array $values
	 */
	public function __construct($values = [])
	{
		$this->valueMap = $values;
	}

	/**
	 * Function to get the value for a given key.
	 *
	 * @param $key
	 *
	 * @return Value for the given key
	 */
	public function get($key)
	{
		return isset($this->valueMap[$key]) ? $this->valueMap[$key] : false;
	}

	/**
	 * Function to set the value for a given key.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return Core_BaseModel
	 */
	public function set($key, $value)
	{
		$this->valueMap[$key] = $value;
		return $this;
	}

	/**
	 * Function to set all the values for the Object.
	 *
	 * @param array (key-value mapping) $values
	 *
	 * @return Core_BaseModel
	 */
	public function setData($values)
	{
		$this->valueMap = $values;
		return $this;
	}

	/**
	 * Function to get all the values of the Object.
	 *
	 * @return array (key-value mapping)
	 */
	public function getData()
	{
		return $this->valueMap;
	}

	/**
	 * Function to check if the key exists.
	 *
	 * @param string $key
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->valueMap);
	}

	/**
	 * Function to check if the key is empty.
	 *
	 * @param type $key
	 */
	public function isEmpty($key)
	{
		return !isset($this->valueMap[$key]) || empty($this->valueMap[$key]);
	}
}
