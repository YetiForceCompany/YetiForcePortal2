<?php
/**
 * There are all requests with responses.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Log;

/**
 * Api class.
 */
class Api extends Base
{
	/**
	 * {@inheritdoc}
	 */
	protected static $fileName = 'cache' . \DIRECTORY_SEPARATOR . 'logs' . \DIRECTORY_SEPARATOR . 'api.log';

	/**
	 * {@inheritdoc}
	 */
	public static function display($value, string $type): string
	{
		$content = '============ ' . date('Y-m-d H:i:s') . ' ============' . PHP_EOL;
		$content .= 'Metod: ' . $value['method'] . PHP_EOL;
		$content .= 'Request: ' . print_r($value['data'], true) . PHP_EOL;
		if (isset($value['rawResponse'])) {
			$content .= 'Response (raw): ' . print_r($value['rawResponse'], true) . PHP_EOL;
		}
		$content .= 'Response: ' . print_r($value['response'], true) . PHP_EOL;
		return $content;
	}
}
