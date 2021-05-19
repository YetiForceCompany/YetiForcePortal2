<?php
/**
 * The file contains: Utils class.
 *
 * @package App
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App;

\define('IS_PUBLIC_DIR', true);
/**
 * Utils class.
 */
class Utils
{
	public static function recurseDelete(string $src)
	{
		$vendorDir = \dirname(__FILE__, 2);
		$rootDir = \dirname($vendorDir, 2) . \DIRECTORY_SEPARATOR;
		if (!file_exists($rootDir . $src)) {
			return;
		}
		$dirs = [];
		if (is_dir($src)) {
			$dirs[] = $rootDir . $src;
		}
		@chmod($rootDir . $src, 0777);
		if (is_dir($src)) {
			foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item) {
				if ($item->isDir()) {
					$dirs[] = $rootDir . $src . \DIRECTORY_SEPARATOR . $iterator->getSubPathName();
				} else {
					unlink($rootDir . $src . \DIRECTORY_SEPARATOR . $iterator->getSubPathName());
				}
			}
			arsort($dirs);
			foreach ($dirs as $dir) {
				rmdir($dir);
			}
		} else {
			unlink($rootDir . $src);
		}
	}

	/**
	 * Get absolute URL for Portal2.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	public static function absoluteUrl(string $url): string
	{
		return \App\Config::get('portalUrl') . $url;
	}

	/**
	 * Get public url from file.
	 *
	 * @param string $name
	 * @param bool   $full
	 *
	 * @return string
	 */
	public static function getPublicUrl($name, $full = false): string
	{
		$basePath = '';
		if ($full) {
			$basePath .= \App\Config::get('portalUrl');
		}
		if (!IS_PUBLIC_DIR) {
			$basePath .= 'public_html/';
		}
		return $basePath . $name;
	}

	/**
	 * Replacement for the ucfirst function for proper Multibyte String operation.
	 * Delete function will exist as mb_ucfirst.
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function mbUcfirst(string $string): string
	{
		return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
	}

	/**
	 * Parse bytes.
	 *
	 * @param mixed $str
	 *
	 * @return float
	 */
	public static function parseBytes($str): float
	{
		if (is_numeric($str)) {
			return (float) $str;
		}
		$bytes = 0;
		if (preg_match('/([0-9\.]+)\s*([a-z]*)/i', $str, $regs)) {
			$bytes = (float) ($regs[1]);
			switch (strtolower($regs[2])) {
				case 'g':
				case 'gb':
					$bytes *= 1073741824;
					break;
				case 'm':
				case 'mb':
					$bytes *= 1048576;
					break;
				case 'k':
				case 'kb':
					$bytes *= 1024;
					break;
				default:
					break;
			}
		}
		return (float) $bytes;
	}

	/**
	 * Show bytes.
	 *
	 * @param mixed       $bytes
	 * @param string|null $unit
	 *
	 * @return string
	 */
	public static function showBytes($bytes, &$unit = null): string
	{
		$bytes = self::parseBytes($bytes);
		if ($bytes >= 1073741824) {
			$unit = 'GB';
			$gb = $bytes / 1073741824;
			$str = sprintf($gb >= 10 ? '%d ' : '%.2f ', $gb) . $unit;
		} elseif ($bytes >= 1048576) {
			$unit = 'MB';
			$mb = $bytes / 1048576;
			$str = sprintf($mb >= 10 ? '%d ' : '%.2f ', $mb) . $unit;
		} elseif ($bytes >= 1024) {
			$unit = 'KB';
			$str = sprintf('%d ', round($bytes / 1024)) . $unit;
		} else {
			$unit = 'B';
			$str = sprintf('%d ', $bytes) . $unit;
		}
		return $str;
	}
}
