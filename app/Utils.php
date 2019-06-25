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

/**
 * Utils class.
 */
class Utils
{
	public static function recurseDelete(string $src)
	{
		$vendorDir = \dirname(\dirname(__FILE__));
		$rootDir = \dirname(\dirname($vendorDir)) . \DIRECTORY_SEPARATOR;
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
}
