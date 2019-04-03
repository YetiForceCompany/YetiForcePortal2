<?php
/**
 * Side menu.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

use App\Config;
use App\Loader;
use App\User;

/**
 * Menu class.
 */
class Menu
{
	protected $allowedModulesInMenu = [];
	protected $additionalMenuItems = [];

	/**
	 * Get instance.
	 *
	 * @param string $module
	 *
	 * @return self
	 */
	public static function getInstance(string $module = 'Base'): self
	{
		$menuClassName = Loader::getModuleClassName($module, 'Model', 'Menu');
		return new $menuClassName();
	}

	/**
	 * Construct.
	 */
	public function __construct()
	{
		$this->allowedModulesInMenu = Config::get('allowedModulesInMenu');
	}

	/**
	 * Get allowed items.
	 *
	 * @return array
	 */
	public function getAllowedItems(): array
	{
		$items = [];
		foreach (User::getUser()->getModulesList() as $key => $module) {
			if (empty($this->allowedModulesInMenu) || in_array($key, $this->allowedModulesInMenu)) {
				$items[$key] = [
					'icon' => "userIcon-{$key}",
					'link' => "index.php?module={$key}&view=ListView",
					'name' => $module,
				];
			}
		}
		return \array_merge($items, $this->additionalMenuItems);
	}
}
