<?php
/**
 * Basic module model class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Install\Model;

use App\Config;
use App\Purifier;

class Install
{
	protected $configPath = 'config/Config.php';
	protected $config = [
		'crmPath' => '__CRM_PATH__',
		'apiKey' => '__API_KEY__',
	];

	public static function getInstance($module)
	{
		$handlerModule = \App\Loader::getModuleClassName($module, 'Model', 'Install');
		return new $handlerModule();
	}

	public static function isInstalled()
	{
		return '__CRM_PATH__' != Config::get('crmUrl');
	}

	public function save(\App\Request $request)
	{
		$configFile = file_get_contents($this->configPath);
		foreach ($this->config as $key => $value) {
			$configFile = str_replace($value, addslashes($request->getByType($key, Purifier::TEXT)), $configFile);
		}
		$webRoot = ($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
		$webRoot .= $_SERVER['REQUEST_URI'];
		$webRoot = str_replace('index.php', '', $webRoot);
		$webRoot = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $webRoot;
		$tabUrl = explode('/', $webRoot);
		unset($tabUrl[count($tabUrl) - 1]);
		$webRoot = implode('/', $tabUrl) . '/';
		$configFile = str_replace('__PORTAL_PATH__', addslashes($webRoot), $configFile);
		file_put_contents($this->configPath, $configFile);
		header('Location: ' . $webRoot);
	}

	public function removeInstallationFiles()
	{
		\App\Utils::recurseDelete('modules/Install/');
		\App\Utils::recurseDelete('language/pl_pl/Install.php');
		\App\Utils::recurseDelete('language/en_us/Install.php');
	}
}
