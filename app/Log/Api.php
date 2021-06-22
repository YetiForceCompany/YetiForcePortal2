<?php
/**
 * There are all requests with responses.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Log;

/**
 * Api class.
 */
class Api extends AbstractBase
{
	/** {@inheritdoc} */
	protected static $fileName = 'cache' . \DIRECTORY_SEPARATOR . 'logs' . \DIRECTORY_SEPARATOR . 'api.log';

	/** {@inheritdoc} */
	public static function display($value, string $type): string
	{
		$content = str_repeat('-', 50) . '  ' . $value['request']['date'] . '  ' . str_repeat('-', 50) . PHP_EOL;
		$content .= 'Trace: ' . PHP_EOL . print_r(\App\Debug::getBacktrace(), true) . PHP_EOL;
		$content .= "Method: [{$value['request']['requestType']}] {$value['request']['method']}\n";
		$content .= 'Headers: ' . print_r($value['request']['headers'], true) . PHP_EOL;
		if (!empty($value['request']['rawBody'])) {
			$content .= "RawBody: \n" . print_r($value['request']['rawBody'], true) . PHP_EOL;
		}
		if (!empty($value['request']['body'])) {
			$content .= 'Body: ' . print_r($value['request']['body'], true) . PHP_EOL . PHP_EOL;
		}
		$content .= "Status: {$value['response']['status']}\n";
		$content .= "Reason phrase: {$value['response']['reasonPhrase']}\n";
		$content .= "Time: {$value['response']['time']} sec.\n";
		if (!empty($value['response']['error'])) {
			$content .= "Error: {$value['response']['error']}\n";
		}
		$headers = [];
		if ('-' !== $value['response']['headers']) {
			foreach ($value['response']['headers'] as $key => $header) {
				$headers[$key] = implode("\n", $header);
			}
			$content .= 'Headers: ' . print_r($headers, true) . PHP_EOL;
		}
		if (!empty($value['response']['rawBody'])) {
			$content .= "RawBody: \n" . print_r($value['response']['rawBody'], true) . PHP_EOL;
		}
		if (!empty($value['response']['body'])) {
			$content .= 'Body: ' . print_r($value['response']['body'], true) . PHP_EOL;
		}
		return $content;
	}
}
