<?php
/**
 * Basic Module Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Install\Model;

use Core;

class Install
{

	protected $configPath = 'config/config.php';
	protected $config = [
		'crmPath' => '__CRM_PATH__',
		'apiKey' => '__API_KEY__',
	];

	public function save(Core\Request $request)
	{
		$configFile = file_get_contents($this->configPath);
		foreach ($this->config as $key => $value) {
			$configFile = str_replace($value, $request->get($key), $configFile);
		}
		file_put_contents($this->configPath, $configFile);
		header('Location: /');
	}

	public static function getInstance($module)
	{
		$handlerModule = Core\Loader::getModuleClassName($module, 'Model', 'Install');
		$instance = new $handlerModule();
		return $instance;
	}
}
