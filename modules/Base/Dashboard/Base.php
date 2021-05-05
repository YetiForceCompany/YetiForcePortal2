<?php
/**
 * Base model for widgets in dashboard.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\Dashboard;

/**
 * Base class for widget.
 */
class Base extends \App\BaseModel
{
	/**
	 * List types of widgets.
	 */
	const WIDGETS_TYPE = [
		'Mini List' => 'MiniList',
		'ChartFilter' => 'ChartFilter'
	];

	/**
	 * Function to return instance of widget for dashboard. Class depends on type of widget.
	 *
	 * @param string $type
	 * @param array  $data
	 *
	 * @return self
	 */
	public static function getInstance(string $type, array $data): self
	{
		if (!isset(static::WIDGETS_TYPE[$type])) {
			throw new \App\Exceptions\AppException('ERR_NOT_FOUND_DASHBOARD', 500);
		}
		$class = '\\YF\\Modules\\Base\\Dashboard\\' . static::WIDGETS_TYPE[$type];
		$widget = new $class();
		$widget->setData($data);
		$widget->set('type', static::WIDGETS_TYPE[$type]);
		return $widget;
	}
}
