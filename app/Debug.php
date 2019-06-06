<?php
/**
 * Debug.
 *
 * @package   Tests
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace App;

/**
 * Class Debug.
 */
class Debug
{
	/**
	 * Get backtrace.
	 *
	 * @param int    $minLevel
	 * @param int    $maxLevel
	 * @param string $sep
	 *
	 * @return string
	 */
	public static function getBacktrace(int $minLevel = 1, int $maxLevel = 0, string $sep = '#'): string
	{
		$trace = '';
		foreach (debug_backtrace() as $k => $v) {
			if ($k < $minLevel) {
				continue;
			}
			if (!isset($v['file'])) {
				continue;
			}
			$l = $k - $minLevel;
			$args = '';
			if (isset($v['args'])) {
				foreach ($v['args'] as &$arg) {
					if (!is_array($arg) && !is_object($arg) && !is_resource($arg)) {
						$args .= var_export($arg, true);
					} elseif (is_array($arg)) {
						$args .= '[';
						foreach ($arg as &$a) {
							$val = $a;
							if (is_array($a) || is_object($a) || is_resource($a)) {
								$val = gettype($a);
								if (is_object($a)) {
									$val .= '(' . get_class($a) . ')';
								}
							}
							$args .= $val . ',';
						}
						$args = rtrim($args, ',') . ']';
					}
					$args .= ',';
				}
				$args = rtrim($args, ',');
			}
			$trace .= "$sep$l {$v['file']} ({$v['line']})  >>  " . (isset($v['class']) ? $v['class'] . '->' : '') . "{$v['function']}($args)" . PHP_EOL;
			if (0 !== $maxLevel && $l >= $maxLevel) {
				break;
			}
		}
		return rtrim(str_replace(YF_ROOT . \DIRECTORY_SEPARATOR, '', $trace), PHP_EOL);
	}
}
