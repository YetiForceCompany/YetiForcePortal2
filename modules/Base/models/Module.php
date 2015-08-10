<?php
/**
 * Basic Module Model Class
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\model;

use Core;

class Module
{

	protected $defaultView = 'List';

	public function getDefaultView()
	{
		return $this->defaultView;
	}

	public static function getInstance($module)
	{
		$handlerModule = Core\Loader::getModuleClassName($module, 'Model', 'Module');
		$instance = new $handlerModule();
		return $instance;
	}
}
