<?php
/**
 * The file contains: Payments log class.
 *
 * @package
 *
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Log;

use App\Payments\Utilities\TransactionState;

/**
 * Class Payments log.
 */
class Payments extends Base
{
	/**
	 * {@inheritdoc}
	 */
	protected static $fileName = 'cache\\logs\\payments.log';

	/**
	 * {@inheritdoc}
	 */
	public static function display($value, string $type): string
	{
		if ($value instanceof TransactionState) {
			$content = static::displayTransactionState($value, $type);
		} else {
			$content = date('Y-m-d H:i:s') . ' [' . $type . '] ' . $value . PHP_EOL . \App\Debug::getBacktrace(4);
		}
		return $content;
	}

	/**
	 * Display transaction state.
	 *
	 * @param TransactionState $value
	 * @param string           $type
	 *
	 * @return string
	 */
	public static function displayTransactionState(TransactionState $value, string $type): string
	{
		$content = '============ ' . date('Y-m-d H:i:s') . " [{$type}]  ============" . PHP_EOL;
		$content .= 'getBacktrace:' . \App\Debug::getBacktrace(4) . PHP_EOL;
		$content .= 'TransactionState: ' . \var_export($value, true);
		return $content;
	}
}
