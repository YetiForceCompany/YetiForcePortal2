<?php
/**
 * System logs. There are logs about system.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Log;

/**
 * System class.
 */
class System extends Base
{
	/**
	 * {@inheritdoc}
	 */
	protected static $fileName = 'cache\\logs\\system.log';

	/**
	 * {@inheritdoc}
	 */
	public static function display($value, string $type): string
	{
		return date('Y-m-d H:i:s') . ' [' . $type . '] ' . $value;
	}
}
