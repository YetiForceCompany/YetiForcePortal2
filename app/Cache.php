<?php
/**
 * Cache main file.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

/**
 * Cache main class.
 */
class Cache
{
	/** @var int Long time data storage */
	const LONG = 3600;

	/** @var int Medium time data storage */
	const MEDIUM = 300;

	/** @var int Short time data storage */
	const SHORT = 60;

	/** @var string The prefix for cache keys. */
	private static $prefix = 'YTP-';

	/** @var \App\Cache\Base Cache instance */
	public static $pool;

	/** @var \App\Cache\Base Static cache instance */
	public static $staticPool;

	/** @var bool Clean the opcache after the script finishes. */
	public static $clearOpcache = false;

	/**
	 * Initialize cache class.
	 *
	 * @return void
	 */
	public static function init(): void
	{
		$token = $_SESSION['user']['token'] ?? '';
		static::$prefix .= ($token ? substr($token, -36) : '') . '-';
		$driver = \App\Config::get('cachingDriver');
		static::$staticPool = new \App\Cache\Base();
		if ($driver) {
			$className = '\App\Cache\\' . $driver;
			static::$pool = new $className();
			return;
		}
		static::$pool = static::$staticPool;
	}

	/**
	 * Returns a Cache Item representing the specified key.
	 *
	 * @param string $key       Cache ID
	 * @param mixed  $nameSpace
	 *
	 * @return mixed
	 */
	public static function get($nameSpace, $key)
	{
		return static::$pool->get(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Confirms if the cache contains specified cache item.
	 *
	 * @param string $nameSpace
	 * @param string $key       Cache ID
	 *
	 * @return bool
	 */
	public static function has($nameSpace, $key): bool
	{
		return static::$pool->has(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Cache Save.
	 *
	 * @param string $key       Cache ID
	 * @param mixed  $value     Data to store, supports string, array, objects
	 * @param int    $duration  Cache TTL (in seconds)
	 * @param mixed  $nameSpace
	 *
	 * @return bool
	 */
	public static function save($nameSpace, $key, $value = null, $duration = self::MEDIUM)
	{
		if (!static::$pool->save(static::$prefix . "{$nameSpace}-{$key}", $value, $duration)) {
			Log::warning("Error writing to cache. Key: $nameSpace-$key | Value: " . var_export($value, true));
		}
		return $value;
	}

	/**
	 * Removes the item from the cache.
	 *
	 * @param string $key       Cache ID
	 * @param mixed  $nameSpace
	 *
	 * @return bool
	 */
	public static function delete($nameSpace, $key)
	{
		static::$pool->delete(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Deletes all items in the cache.
	 *
	 * @return bool
	 */
	public static function clear()
	{
		static::$pool->clear();
	}

	/**
	 * Returns a static Cache Item representing the specified key.
	 *
	 * @param string $nameSpace
	 * @param string $key       Cache ID
	 *
	 * @return mixed
	 */
	public static function staticGet($nameSpace, $key)
	{
		return static::$staticPool->get(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Confirms if the static cache contains specified cache item.
	 *
	 * @param string $nameSpace
	 * @param string $key       Cache ID
	 *
	 * @return bool
	 */
	public static function staticHas($nameSpace, $key)
	{
		return static::$staticPool->has(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Static cache save.
	 *
	 * @param string $nameSpace
	 * @param string $key       Cache ID
	 * @param mixed  $value     Data to store
	 * @param int    $duration  Cache TTL (in seconds)
	 *
	 * @return bool
	 */
	public static function staticSave($nameSpace, $key, $value = null)
	{
		return static::$staticPool->save(static::$prefix . "{$nameSpace}-{$key}", $value);
	}

	/**
	 * Removes the item from the static cache.
	 *
	 * @param string $nameSpace
	 * @param string $key       Cache ID
	 *
	 * @return bool
	 */
	public static function staticDelete($nameSpace, $key)
	{
		static::$staticPool->delete(static::$prefix . "{$nameSpace}-{$key}");
	}

	/**
	 * Deletes all items in the static cache.
	 *
	 * @return bool
	 */
	public static function staticClear()
	{
		static::$staticPool->clear();
	}

	/**
	 * Clear the opcache after the script finishes.
	 *
	 * @return bool
	 */
	public static function clearOpcache()
	{
		if (static::$clearOpcache) {
			return false;
		}
		register_shutdown_function(function () {
			static::resetOpcache();
		});
		static::$clearOpcache = true;
	}

	/**
	 * Reset opcache if it is possible.
	 */
	public static function resetOpcache()
	{
		if (\function_exists('opcache_reset')) {
			\opcache_reset();
		}
	}

	/**
	 * Reset file from opcache if it is possible.
	 *
	 * @param string $path
	 */
	public static function resetFileCache(string $path)
	{
		if (\function_exists('opcache_invalidate')) {
			\opcache_invalidate($path);
		}
	}

	/**
	 * Clear all cache.
	 */
	public static function clearAll()
	{
		static::clearOpcache();
		static::clear();
		clearstatcache();
	}

	/**
	 * Check whether it's the primary driver.
	 *
	 * @return bool
	 */
	public static function isBase(): bool
	{
		return 'App\Cache\Base' === \get_class(static::$staticPool);
	}
}
