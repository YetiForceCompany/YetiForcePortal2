<?php
/**
 * Menu class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace App;

class Menu
{
	/**
	 * Get breadcrumbs.
	 *
	 * @param string $pageTitle
	 *
	 * @return array
	 */
	public static function getBreadcrumbs($pageTitle = false)
	{
		$request = Request::getInstance();
		$moduleName = $request->get('module');
		$view = $request->get('view');
		$basic = [];
		$basic['name'] = Language::translateModule($moduleName);

		if (Session::has('Modules') && isset(Session::get('Modules')[$moduleName])) {
			$basic['url'] = "index.php?module=$moduleName&view=ListView";
		}
		$breadcrumbs[] = $basic;
		if ('EditView' === $view && empty($request->get('record'))) {
			$breadcrumbs[] = ['name' => Language::translate('LBL_VIEW_CREATE', $moduleName)];
		} elseif (!empty($view) && 'index' !== $view && 'Index' !== $view) {
			$breadcrumbs[] = ['name' => Language::translate('LBL_VIEW_' . strtoupper($view), $moduleName)];
		} elseif (empty($view)) {
			$breadcrumbs[] = ['name' => Language::translate('LBL_HOME', $moduleName)];
		}
		if ($pageTitle) {
			$breadcrumbs[] = ['name' => $pageTitle];
		}
		return $breadcrumbs;
	}
}
