<?php
/**
 * The file contains: Class to handle the currency in the ISO 4217 standard.
 *
 * @package App
 *
 * @copyright YetiForce S.A.
 * @license YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App\Payments\Utilities;

/**
 * Class to handle the currency in the ISO 4217 standard.
 */
class CurrencyISO4217
{
	/**
	 * @see https://en.wikipedia.org/wiki/ISO_4217
	 */
	const CURRENCY_ISO_4217 = [
		'EUR' => [
			'code' => 978,
			'numberOfDigitsAfter' => 2,
		],
		'PLN' => [
			'code' => 985,
			'numberOfDigitsAfter' => 2,
		],
		'USD' => [
			'code' => 840,
			'numberOfDigitsAfter' => 2,
		],
	];

	/**
	 * Get currency information by code.
	 *
	 * @param int $code
	 *
	 * @return array
	 */
	public static function getInfoFromCode(int $code): array
	{
		foreach (static::CURRENCY_ISO_4217 as $symbol => $currency) {
			if ($code === $currency['code']) {
				return $currency + ['symbol' => $symbol];
			}
		}
		return [];
	}

	/**
	 * Get currency information by symbol.
	 *
	 * @param string $symbol
	 *
	 * @return array
	 */
	public static function getInfoFromSymbol(string $symbol): array
	{
		return isset(static::CURRENCY_ISO_4217[$symbol]) ? static::CURRENCY_ISO_4217[$symbol] + ['symbol' => $symbol] : [];
	}
}
