<?php
/**
 * Server.
 *
 * @package   App
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Class Server.
 */
class Server
{
	public static function getRemoteIP(bool $onlyIP = false): string
	{
		$address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
		// append the NGINX X-Real-IP header, if set
		if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
			$remote_ip[] = 'X-Real-IP: ' . $_SERVER['HTTP_X_REAL_IP'];
		}
		// append the X-Forwarded-For header, if set
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remote_ip[] = 'X-Forwarded-For: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if (!empty($remote_ip) && false === $onlyIP) {
			$address .= '(' . implode(',', $remote_ip) . ')';
		}
		return $address;
	}
}
