<?php
/**
 * Menu class
 * @package YetiForce.Config
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Tomasz Kur <t.kur@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Core;

class Menu
{

	/**
	 * Get breadcrumbs
	 * @param string $pageTitle
	 * @return array
	 */
	static public function getBreadcrumbs($pageTitle = false)
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
		if ($view === 'EditView' && empty($request->get('record'))) {
			$breadcrumbs[] = ['name' => Language::translate('LBL_VIEW_CREATE', $moduleName)];
		} elseif (!empty($view) && $view !== 'index' && $view !== 'Index') {
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
