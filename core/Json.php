<?php
/**
 * Json class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Core;

class Json
{

	/**
	 * How objects should be encoded -- arrays or as StdClass. TYPE_ARRAY is 1
	 * so that it is a boolean true value, allowing it to be used with
	 * ext/json's functions.
	 */
	const TYPE_ARRAY = 1;
	const TYPE_OBJECT = 0;

	public static function decode($encodedValue, $objectDecodeType = Json::TYPE_ARRAY)
	{
		return json_decode($encodedValue, $objectDecodeType);
	}

	public static function encode($valueToEncode, $cycleCheck = false)
	{
		return json_encode($valueToEncode);
	}
}
