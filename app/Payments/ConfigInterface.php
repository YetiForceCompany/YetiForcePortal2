<?php
/**
 * The file contains: Payment configuration interface.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments;

/**
 * Payment configuration interface.
 */
interface ConfigInterface
{
	/**
	 * Return the value by the key.
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get(string $key);

	/**
	 * Does the key exist in the configuration.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * Check if the value in the configuration is empty.
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function isEmpty(string $key): bool;
}
