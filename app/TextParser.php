<?php

namespace App;

/**
 * Text parser class.
 *
 * @package App
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Sołek <a.solek@yetiforce.com>
 */
class TextParser
{
	/**
	 * Truncating text.
	 *
	 * @param string   $text
	 * @param bool|int $length
	 * @param bool     $addDots
	 *
	 * @return string
	 */
	public static function textTruncate($text, $length = false, $addDots = true)
	{
		if (!$length) {
			$length = 40;
		}
		$textLength = mb_strlen($text);
		if ((!$addDots && $textLength > $length) || ($addDots && $textLength > $length + 2)) {
			$text = mb_substr($text, 0, $length, 'UTF-8');
			if ($addDots) {
				$text .= '...';
			}
		}
		return $text;
	}
}
