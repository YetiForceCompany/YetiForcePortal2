<?php

namespace App\Fields;

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
		return $display;
	}
}
