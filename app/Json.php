<?php
/**
 * The file contains: Json class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author 	  Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Json class.
 */
class Json
{
	/**
	 * How objects should be encoded -- arrays or as StdClass. TYPE_ARRAY is 1
	 * so that it is a boolean true value, allowing it to be used with
	 * ext/json's functions.
	 */
	const TYPE_ARRAY = true;
	const TYPE_OBJECT = false;

	/**
	 * Decode JSON to value.
	 *
	 * @param string $encodedValue
	 * @param bool   $objectDecodeType
	 *
	 * @return mixed
	 */
	public static function decode(string $encodedValue, bool $objectDecodeType = self::TYPE_ARRAY)
	{
		return json_decode($encodedValue, $objectDecodeType);
	}

	/**
	 * Encode value to JSON.
	 *
	 * @param mixed $valueToEncode
	 *
	 * @return string
	 */
	public static function encode($valueToEncode): string
	{
		return json_encode($valueToEncode);
	}

	/**
	 * Determine whether a variable is empty.
	 *
	 * @param string|null $value
	 *
	 * @return bool
	 */
	public static function isEmpty(?string $value): bool
	{
		return empty($value) || '[]' === $value || '""' === $value;
	}
}
