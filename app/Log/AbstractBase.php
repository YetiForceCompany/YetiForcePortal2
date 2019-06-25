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
abstract class AbstractBase
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
	public static $messages = [];

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
		static::$messages[static::class][] = static::display($value, $type);
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
		if (!empty(static::$messages[static::class])) {
			$content = static::preContent();
			$content .= PHP_EOL . implode(PHP_EOL, static::$messages[static::class]);
			$content .= static::postContent();
			file_put_contents(YF_ROOT . \DIRECTORY_SEPARATOR . static::$fileName, $content, FILE_APPEND);
		}
	}

	/**
	 * Returns text before logs.
	 *
	 * @return string
	 */
	protected static function preContent(): string
	{
		return '';
	}

	/**
	 * Returns text after logs.
	 *
	 * @return string
	 */
	protected static function postContent(): string
	{
		return PHP_EOL . 'REQUEST = ' . print_r($_REQUEST, true);
	}
}
