<?php
/**
 * Log class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App;

/**
 * Log class.
 */
class Log
{
	const ERROR = 'error';
	const WARNING = 'warning';
	const TRACE = 'trace';
	const INFO = 'info';

	/**
	 * List of available logs.
	 *
	 * @var array
	 */
	private static $category = ['System', 'Api'];

	/**
	 * Initial process.
	 *
	 * @return void
	 */
	public static function init()
	{
		register_shutdown_function(function () {
			static::flush();
		});
	}

	/**
	 * Add error to log.
	 *
	 * @param mixed  $value
	 * @param string $category
	 *
	 * @return void
	 */
	public static function error($value, string $category = 'System')
	{
		static::log($value, static::ERROR, $category);
	}

	/**
	 * Add warning to log.
	 *
	 * @param mixed  $value
	 * @param string $category
	 *
	 * @return void
	 */
	public static function warning($value, string $category = 'System')
	{
		static::log($value, static::WARNING, $category);
	}

	/**
	 * Add trace to log.
	 *
	 * @param mixed  $value
	 * @param string $category
	 *
	 * @return void
	 */
	public static function trace($value, string $category = 'System')
	{
		static::log($value, static::TRACE, $category);
	}

	/**
	 * Add info to log.
	 *
	 * @param mixed  $value
	 * @param string $category
	 *
	 * @return void
	 */
	public static function info($value, string $category = 'System')
	{
		static::log($value, static::INFO, $category);
	}

	/**
	 * Add message to log.
	 *
	 * @param mixed  $value
	 * @param string $type
	 * @param string $category
	 *
	 * @return void
	 */
	private static function log($value, string $type, string $category)
	{
		if (!in_array($category, static::$category)) {
			throw new AppException('Category not found', 500);
		}
		$className = '\\App\Log\\' . $category;
		$className::log($value, $type);
	}

	/**
	 * Save logs.
	 *
	 * @return void
	 */
	public static function flush()
	{
		foreach (static::$category as $category) {
			$className = '\\App\Log\\' . $category;
			$className::flush();
		}
	}
}
