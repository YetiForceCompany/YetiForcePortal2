<?php

/**
 * Purifier basic class.
 *
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @copyright YetiForce Sp. z o.o
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App;

/**
 * Class to purify data.
 */
class Purifier
{
	/**
	 * Default charset.
	 *
	 * @var string
	 */
	public static $defaultCharset;

	const TEXT = 'Text';
	const STANDARD = 'Standard';
	const ALNUM = 'Alnum';
	const ALNUM_EXTENDED = 'AlnumExtended';
	const INTEGER = 'Integer';

	/**
	 * Purify by data type.
	 *
	 * @param mixed  $input
	 * @param string $type  Data type that is only acceptable
	 *
	 * @return mixed
	 */
	public static function purifyByType($input, $type)
	{
		if (\is_array($input)) {
			$value = [];
			foreach ($input as $k => $v) {
				$value[$k] = static::purifyByType($v, $type);
			}
		} else {
			$value = null;
			switch ($type) {
				case static::STANDARD:
					$value = preg_match('/^[\-_a-zA-Z]+$/', $input) ? $input : null;
					break;
				case static::ALNUM:
					$value = preg_match('/^[[:alnum:]_]+$/', $input) ? $input : null;
					break;
				case static::ALNUM_EXTENDED:
					$value = preg_match('/^[\sA-Za-z0-9\-]+$/', $input) ? $input : null;
					break;
				case static::INTEGER:
					if (false !== ($input = filter_var($input, FILTER_VALIDATE_INT))) {
						$value = $input;
					}
					break;
				case static::TEXT:
				default:
					$value = trim(strip_tags($input));
					break;
			}
			if (null === $value) {
				throw new \App\Exceptions\IllegalValue('ERR_NOT_ALLOWED_VALUE||' . $input, 406);
			}
		}
		return $value;
	}

	/**
	 * Function to convert the given string to html.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function encodeHtml(string $string): string
	{
		return htmlspecialchars($string, ENT_QUOTES, static::$defaultCharset);
	}

	/**
	 * Function to decode html.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function decodeHtml(string $string): string
	{
		return html_entity_decode($string, ENT_QUOTES, static::$defaultCharset);
	}
}

Purifier::$defaultCharset = (string) \App\Config::get('defaultCharset', 'UTF-8');
