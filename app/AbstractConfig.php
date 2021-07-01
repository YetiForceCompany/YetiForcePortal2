<?php
/**
 * The file contains: AbstractConfig class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Abstract class to handle configuration from PHP files.
 */
abstract class AbstractConfig implements Payments\ConfigInterface
{
	/**
	 * Get config.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get(string $key)
	{
		if (!\property_exists($this, $key)) {
			throw new \Exception('There is no configuration for the key: ' . $key);
		}
		return $this->{$key};
	}

	/**
	 * Check if it has a property.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool
	{
		return \property_exists($this, $key);
	}

	/**
	 * Check if the value is empty.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function isEmpty(string $key): bool
	{
		return $this->has($key) && empty($this->get($key));
	}
}
