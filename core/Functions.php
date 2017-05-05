<?php
/**
 * Functions class
 * @package YetiForce.Core
 * @license licenses/License.html
 */
namespace YF\Core;

class Functions
{

	public static function translate($label, $module = 'Basic')
	{
		return \YF\Core\Language::translate($label, $module);
	}

	public static function fileTemplate($name, $moduleName, $type = 'images')
	{
		$filePath = YF_ROOT_WWW . 'layouts' . DIRECTORY_SEPARATOR . \YF\Core\Viewer::getLayoutName() . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			$filePath = str_replace(DIRECTORY_SEPARATOR, '/', $filePath);
			return $filePath;
		}
		$filePath = YF_ROOT_WWW . 'layouts' . DIRECTORY_SEPARATOR . \YF\Core\Viewer::getLayoutName() . DIRECTORY_SEPARATOR . 'skins' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			$filePath = str_replace(DIRECTORY_SEPARATOR, '/', $filePath);
			return $filePath;
		}
		return $name;
	}

	public static function templatePath($templateName, $moduleName = '')
	{
		$viewer = new \YF\Core\Viewer();
		$args = func_get_args();
		return call_user_func_array([$viewer, 'getTemplatePath'], $args);
	}

	public static function getRemoteIP($onlyIP = false)
	{
		$address = $_SERVER['REMOTE_ADDR'];

		// append the NGINX X-Real-IP header, if set
		if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
			$remote_ip[] = 'X-Real-IP: ' . $_SERVER['HTTP_X_REAL_IP'];
		}
		// append the X-Forwarded-For header, if set
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remote_ip[] = 'X-Forwarded-For: ' . $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		if (!empty($remote_ip) && $onlyIP == false) {
			$address .= '(' . implode(',', $remote_ip) . ')';
		}
		return $address;
	}

	public static function getTranslatedModuleName($moduleName)
	{
		return Session::get('modules')[$moduleName];
	}

	public static function getBacktrace($minLevel = 1, $maxLevel = 0, $sep = '#')
	{
		$trace = '';
		foreach (debug_backtrace() as $k => $v) {
			if ($k < $minLevel) {
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
			if ($maxLevel !== 0 && $l >= $maxLevel) {
				break;
			}
		}
		return rtrim(str_replace(YF_ROOT . DIRECTORY_SEPARATOR, '', $trace), PHP_EOL);
	}

	/**
	 * Function to make the input safe to be used as HTML
	 * @param string $text
	 * @return string
	 */
	public static function toSafeHTML($text)
	{
		return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}
}
