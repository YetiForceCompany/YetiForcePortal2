<?php
/**
 * Menu class
 * @package YetiForce.Config
 * @license licenses/License.html
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
namespace Core;
class Menu
{
	static public function getBreadcrumbs()
	{
		$breadcrumbs = false;
		$request = new Request($_REQUEST);
		$moduleName = $request->get('module');
		$view = $request->get('view');
		$breadcrumbs[] = [ 'name' => Language::translate($moduleName)];
		if ($view == 'EditView' && $request->get('record') == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_CREATE', $moduleName)];
		} elseif ($view != '' && $view != 'index' && $view != 'Index') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_VIEW_' . strtoupper($view), $moduleName)];
		} elseif ($view == '') {
			$breadcrumbs[] = [ 'name' => Language::translate('LBL_HOME', $moduleName)];
		}
		if ($request->get('record') != '') {
			$recordLabel = $request->get('record');
			if ($recordLabel != '') {
				$breadcrumbs[] = [ 'name' => $recordLabel];
			}
		}
		return $breadcrumbs;
	}
}
