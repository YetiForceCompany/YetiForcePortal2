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
use App\Language;
use App\Loader;

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
	 * Get menu list.
	 *
	 * @return array
	 */
	public function getItemsFromSystem(): array
	{
		if (\App\Cache::has('MenuItems', 'Items')) {
			return \App\Cache::get('MenuItems', 'Items');
		}
		$menus = \App\Api::getInstance()->call('Menu')['items'];
		\App\Cache::save('MenuItems', 'Items', $menus, \App\Cache::LONG);
		return $menus;
	}

	private function getItemModule(array $row)
	{
		return [
			'id' => $row['id'],
			'type' => $row['type'],
			'childs' => array_map([$this, 'getItemModule'], $row['childs']),
			'name' => $row['name'],
			'icon' => 'yfm-' . $row['mod'],
			'link' => Module::getInstance($row['mod'])->getDefaultUrl(),
			'parent' => $row['parent']
		];
	}

	private function getItem(array $row)
	{
		$methodName = 'getItem' . ucfirst($row['type']);
		if (method_exists($this, $methodName)) {
			return $this->{$methodName}($row);
		}
		return [
			'id' => $row['id'],
			'type' => $row['type'],
			'childs' => array_map([$this, 'getItem'], $row['childs']),
			'name' => $row['name'],
			'icon' => $row['icon'],
			'link' => $row['dataurl'],
			'parent' => $row['parent']
		];
	}

	/**
	 * Get allowed items.
	 *
	 * @return array
	 */
	public function getMenu(): array
	{
		$items = [];
		$menu = $this->getItemsFromSystem();
		if (empty($menu)) {
			$defaultModule = Config::get('defaultModule');
			return [
				[
					'type' => 'Module',
					'id' => '',
					'childs' => [],
					'name' => Language::translateModule($defaultModule),
					'icon' => 'yfm-' . $defaultModule,
					'link' => "index.php?module={$defaultModule}&view=ListView"
				]
			];
		}
		foreach ($menu as $values) {
			$items[] = $this->getItem($values);
		}
		return $items;
	}
}
