<?php
/**
 * Side menu.
 *
 * @package   Model
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Arkadiusz Adach <a.adach@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Model;

/**
 * Menu class.
 */
class Menu
{
	/**
	 * Get instance.
	 *
	 * @param string $module
	 *
	 * @return self
	 */
	public static function getInstance(string $module = 'Base'): self
	{
		$menuClassName = \App\Loader::getModuleClassName($module, 'Model', 'Menu');
		return new $menuClassName();
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

	/**
	 * Get module type menu.
	 *
	 * @param array $row
	 *
	 * @return array
	 */
	protected function getItemModule(array $row): array
	{
		$row['link'] = Module::getInstance($row['mod'])->getDefaultUrl();
		$row['icon'] = $row['icon'] ?? ('yfm-' . $row['mod']);
		$row['childs'] = array_map([$this, 'getItem'], $row['childs']);
		return $row;
	}

	/**
	 * Get base type menu.
	 *
	 * @param array $row
	 *
	 * @return array
	 */
	protected function getItem(array $row)
	{
		$methodName = 'getItem' . ucfirst($row['type']);
		if (method_exists($this, $methodName)) {
			return $this->{$methodName}($row);
		}
		$row['link'] = $row['dataurl'];
		$row['childs'] = array_map([$this, 'getItem'], $row['childs']);
		return $row;
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
			$defaultModule = \App\Config::get('defaultModule');
			return [
				[
					'type' => 'Module',
					'id' => '',
					'childs' => [],
					'name' => $defaultModule,
					'label' => \App\Language::translateModule($defaultModule),
					'icon' => 'yfm-' . $defaultModule,
					'link' => "index.php?module={$defaultModule}&view=ListView",
				],
			];
		}
		foreach ($menu as $values) {
			$items[] = $this->getItem($values);
		}
		return $items;
	}
}
