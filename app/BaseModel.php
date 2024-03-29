<?php
/**
 * Base class.
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

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
	public function __construct(array $values = [])
	{
		$this->valueMap = $values;
	}

	/**
	 * Function to get the value for a given key.
	 *
	 * @param string $key
	 * @param mixed  $defaultValue
	 *
	 * @return mixed for the given key
	 */
	public function get(string $key, $defaultValue = false)
	{
		return $this->valueMap[$key] ?? $defaultValue;
	}

	/**
	 * Function to set the value for a given key.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function set(string $key, $value)
	{
		$this->valueMap[$key] = $value;
		return $this;
	}

	/**
	 * Function to set all the values for the Object.
	 *
	 * @param array (key-value mapping) $values
	 *
	 * @return $this
	 */
	public function setData(array $values): self
	{
		$this->valueMap = $values;
		return $this;
	}

	/**
	 * Function to get all the values of the Object.
	 *
	 * @return array (key-value mapping)
	 */
	public function getData(): array
	{
		return $this->valueMap;
	}

	/**
	 * Function to check if the key exists.
	 *
	 * @param string $key
	 */
	public function has(string $key): bool
	{
		return \array_key_exists($key, $this->valueMap);
	}

	/**
	 * Function to check if the key is empty.
	 *
	 * @param string $key
	 */
	public function isEmpty(string $key): bool
	{
		return empty($this->valueMap[$key]);
	}
}
