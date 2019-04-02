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
	protected $allowedMenuItems = [];
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
		$this->allowedMenuItems = Config::get('allowedMenuItems');
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
			if (empty($this->allowedMenuItems) || in_array($key, $this->allowedMenuItems)) {
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
