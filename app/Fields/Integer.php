<?php
/**
 * Integer class.
 *
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce Sp. z o.o
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Fields;

/**
 * Class to display integers.
 */
class Integer
{
	/**
	 * Display integer in user format.
	 *
	 * @param int $value
	 *
	 * @return string
	 */
	public static function formatToDisplay(int $value): string
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
