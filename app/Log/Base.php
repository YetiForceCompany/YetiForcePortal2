<?php
/**
 * Base writer logs.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Log;

/**
 * Base class.
 */
abstract class Base
{
	/**
	 * Path of file.
	 *
	 * @var string
	 */
	protected static $fileName;
	/**
	 * Messages.
	 *
	 * @var array
	 */
	protected static $messages = [];

	/**
	 * Add log.
	 *
	 * @param mixed  $value
	 * @param string $type
	 *
	 * @return void
	 */
	public static function log($value, string $type)
	{
		static::$messages[] = static::display($value, $type);
	}

	/**
	 * Display message.
	 *
	 * @param mixed  $value
	 * @param string $type
	 *
	 * @return string
	 */
	abstract public static function display($value, string $type): string;

	/**
	 * Save logs.
	 *
	 * @return void
	 */
	public static function flush()
	{
		file_put_contents(YF_ROOT . \DIRECTORY_SEPARATOR . static::$fileName, PHP_EOL . implode(PHP_EOL, static::$messages), FILE_APPEND);
	}
}
