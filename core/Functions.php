<?php

class FN
{

	public static function translate($label, $module)
	{
		return Core\Language::translate($label, $module);
	}

	public static function fileTemplate($name, $moduleName, $type = 'images')
	{
		$filePath = 'layouts' . DIRECTORY_SEPARATOR . Core\Viewer::getLayoutName() . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			$filePath = str_replace(DIRECTORY_SEPARATOR, '/', $filePath);
			return $filePath;
		}
		$filePath = 'layouts' . DIRECTORY_SEPARATOR . Core\Viewer::getLayoutName() . DIRECTORY_SEPARATOR . 'skins' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;
		if (file_exists($filePath)) {
			$filePath = str_replace(DIRECTORY_SEPARATOR, '/', $filePath);
			return $filePath;
		}
		return $name;
	}

	public static function templatePath($templateName, $moduleName = '')
	{
		$viewer = new \Core\Viewer();
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
		return $_SESSION['modules'][$moduleName];
	}
}
