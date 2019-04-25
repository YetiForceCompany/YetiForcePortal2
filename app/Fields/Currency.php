<?php
/**
 * Currency class.
 *
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce Sp. z o.o
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Fields;

/**
 * Class to manage currencies.
 */
class Currency
{
	public static function formatToDisplay($value)
	{
		if (empty($value)) {
			$value = 0;
		}
		$userModel = \App\User::getUser();
		$value = number_format((float) $value, $userModel->getPreferences('no_of_currency_decimals'), '.', '');

		[$integer, $decimal] = array_pad(explode('.', $value, 2), 2, false);

		$display = Integer::formatToDisplay($integer);
		$decimalSeperator = $userModel->getPreferences('currency_decimal_separator');
		if ($userModel->getPreferences('truncate_trailing_zeros')) {
			$display = static::truncateZeros($display . $decimalSeperator . $decimal);
		} elseif ($decimal) {
			$display .= $decimalSeperator . $decimal;
		}
		return $display . ' ' . $userModel->getPreferences('currency_symbol');
	}
}
