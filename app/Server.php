<?php
/**
 * Server.
 *
 * @package   App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Class Server.
 */
class Server
{
	/**
	 * Get remote IP.
	 *
	 * @return string
	 */
	public static function getRemoteIp(): string
	{
		return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
	}

	/**
	 * Get all remote IPs.
	 *
	 * @return array
	 */
	public static function getAllRemoteIps(): array
	{
		$ipAddresses = [
			'REMOTE_ADDR' => static::getRemoteIp()
		];
		foreach (['HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP'] as $ipKey) {
			if (!empty($_SERVER[$ipKey])) {
				$ipAddresses[$ipKey] = $_SERVER[$ipKey];
			}
		}
		return $ipAddresses;
	}
}
