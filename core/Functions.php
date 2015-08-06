<?php

function translate($label, $module)
{
	return Core\Language::translate($label, $module);
}

function fileTemplate($name, $moduleName, $type = 'images')
{
	$filePath = 'layouts' . DIRECTORY_SEPARATOR . Core\Viewer::getLayoutName() . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;
	if (file_exists($filePath)) {
		$filePath = str_replace(DIRECTORY_SEPARATOR, '/', $filePath);
		return $filePath;
	}
	return $name;
}
