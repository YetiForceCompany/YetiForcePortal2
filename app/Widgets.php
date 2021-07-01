<?php
/**
 * Widget base file.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

/**
 * Widget class.
 */
final class Widgets
{
	/** @var string Module name. */
	private $moduleName;

	/**
	 * Get instance.
	 *
	 * @param string $moduleName
	 *
	 * @return self
	 */
	public static function getInstance(string $moduleName): self
	{
		$instance = new self();
		$instance->moduleName = $moduleName;
		return $instance;
	}

	/**
	 * Get all widgets.
	 *
	 * @return array
	 */
	public function getAll(): array
	{
		$widgets = [];
		if (\App\Cache::has('Widgets', $this->moduleName)) {
			$widgetsData = \App\Cache::get('Widgets', $this->moduleName);
		} else {
			$widgetsData = \App\Api::getInstance()->call("{$this->moduleName}/Widgets") ?: [];
			\App\Cache::save('Widgets', $this->moduleName, $widgetsData, \App\Cache::LONG);
		}
		foreach ($widgetsData as $widgetData) {
			if (!\in_array($widgetData['type'], ['RelatedModule', 'Updates', 'Comments', 'DetailView'])) {
				continue;
			}
			$handlerModule = \App\Loader::getModuleClassName($this->moduleName, 'Widget', $widgetData['type']);
			$widget = new $handlerModule($this->moduleName);
			$widget->setData($widgetData);
			$widgets[$widgetData['id']] = $widget;
		}
		return $widgets;
	}
}
