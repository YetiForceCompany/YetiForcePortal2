<?php
/**
 * Basic module model class
 * @package YetiForce.Model
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Install\Model;

use YF\Core;

class Install
{

	protected $configPath = 'config/config.php';
	protected $config = [
		'crmPath' => '__CRM_PATH__',
		'apiKey' => '__API_KEY__',
	];

	public function save(\YF\Core\Request $request)
	{
		$configFile = file_get_contents($this->configPath);
		foreach ($this->config as $key => $value) {
			$configFile = str_replace($value, $request->get($key), $configFile);
		}
		file_put_contents($this->configPath, $configFile);
		header('Location: /');
	}

	public function removeInstallationFiles()
	{
		$this->recurseDelete('modules/Install/');
		$this->recurseDelete('language/pl_pl/Install.php');
		$this->recurseDelete('language/en_us/Install.php');
	}

	public function recurseDelete($src)
	{
		$vendorDir = dirname(dirname(__FILE__));
		$rootDir = dirname(dirname($vendorDir)) . DIRECTORY_SEPARATOR;

		if (!file_exists($rootDir . $src))
			return;
		$dirs = [];
		if (is_dir($src)) {
			$dirs [] = $rootDir . $src;
		}
		@chmod($root_dir . $src, 0777);
		if (is_dir($src)) {
			foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item) {
				if ($item->isDir()) {
					$dirs[] = $rootDir . $src . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
				} else {
					unlink($rootDir . $src . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
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

	public static function getInstance($module)
	{
		$handlerModule = \YF\Core\Loader::getModuleClassName($module, 'Model', 'Install');
		$instance = new $handlerModule();
		return $instance;
	}
}
