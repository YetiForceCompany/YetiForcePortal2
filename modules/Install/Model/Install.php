<?php
/**
 * Install model file.
 *
 * @package Model
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Install\Model;

use App\Api;
use App\Config;
use App\Purifier;

/**
 * Install model class.
 */
class Install
{
	protected $configPath = 'config/Config.php';
	protected $config = [
		'apiUrl' => '__API_PATH__',
		'apiKey' => '__API_KEY__',
		'serverName' => '__SERVER_NAME__',
		'serverPass' => '__SERVER_PASS__',
	];

	public static function getInstance($module)
	{
		$handlerModule = \App\Loader::getModuleClassName($module, 'Model', 'Install');
		return new $handlerModule();
	}

	/**
	 * Check if application is installed.
	 *
	 * @return bool
	 */
	public static function isInstalled()
	{
		return '__API_PATH__' !== Config::get('apiUrl');
	}

	/**
	 * Checks connection.
	 *
	 * @return bool
	 */
	public function check(): bool
	{
		$response = Api::getInstance()->call('Install', ['data' => 'Install Wizard'], 'PUT');
		return 'Install Wizard' === $response;
	}

	/**
	 * Save configuration.
	 *
	 * @param \App\Request $request
	 *
	 * @return void
	 */
	public function save(\App\Request $request): void
	{
		$path = ROOT_DIRECTORY . \DIRECTORY_SEPARATOR . $this->configPath;
		$configFile = file_get_contents($path);
		foreach ($this->config as $key => $value) {
			$configFile = str_replace('\'' . $value . '\'', var_export($request->getByType($key, Purifier::TEXT), true), $configFile);
		}
		$webRoot = ($_SERVER['HTTP_HOST']) ?: $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
		$webRoot .= $_SERVER['REQUEST_URI'];
		$webRoot = str_replace('index.php', '', $webRoot);
		$webRoot = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://') . $webRoot;
		$tabUrl = explode('/', $webRoot);
		unset($tabUrl[\count($tabUrl) - 1]);
		$webRoot = implode('/', $tabUrl) . '/';
		$configFile = str_replace('__PORTAL_PATH__', addslashes($webRoot), $configFile);
		Config::$portalUrl = $webRoot;
		file_put_contents($path, $configFile);
		\App\Cache::resetFileCache($path);
	}

	public function removeInstallationFiles()
	{
		\App\Utils::recurseDelete('modules/Install/');
		\App\Utils::recurseDelete('language/pl_pl/Install.php');
		\App\Utils::recurseDelete('language/en_us/Install.php');
	}
}
