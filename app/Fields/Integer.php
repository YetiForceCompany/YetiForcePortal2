<?php

namespace App\Fields;

class Integer
{
	public static function formatToDisplay($value)
	{
		if (empty($value)) {
			return '0';
		}
		$userModel = \App\User::getUser();
		$groupSeperator = $userModel->getPreferences('currency_grouping_separator');
		$groupPatern = $userModel->getPreferences('currency_grouping_pattern');
		if (($length = mb_strlen($value)) > 3) {
			switch ($groupPatern) {
				case '123,456,789':
					$value = preg_replace('/(\d)(?=(\d\d\d)+(?!\d))/', "$1{$groupSeperator}", $value);
					break;
				case '123456,789':
					$value = substr($value, 0, $length - 3) . $groupSeperator . substr($value, $length - 3);
					break;
				case '12,34,56,789':
					$value = preg_replace('/(\d)(?=(\d\d)+(?!\d))/', "$1{$groupSeperator}", substr($value, 0, $length - 3)) . $groupSeperator . substr($value, $length - 3);
					break;
				default:

					break;
			}
		}
		return $value;
	}
}
