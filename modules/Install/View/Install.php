<?php
/**
 * Install view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Install\View;

class Install extends \App\Controller\View
{
	public function __construct()
	{
		$this->exposeMethod('Step1');
		$this->exposeMethod('Step2');
	}

	public function loginRequired()
	{
		return false;
	}

	public function checkPermission(\App\Request $request)
	{
		return true;
	}

	public function preProcess(\App\Request $request, $display = true)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$request = $this->setLanguage($request);
		parent::preProcess($request, $display);
		$viewer->view('InstallPreProcess.tpl', $module);
	}

	public function process(\App\Request $request)
	{
		$module = $request->getModule();
		$mode = $request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			return $this->{$mode}($request);
		}
		$this->Step1($request);
	}

	public function Step1(\App\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallStep1.tpl', $module);
	}

	public function Step2(\App\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallStep2.tpl', $module);
	}

	public function postProcess(\App\Request $request, $display = true)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallPostProcess.tpl', $module);
		parent::postProcess($request, $display);
	}

	public function setLanguage($request)
	{
		if ($request->get('lang')) {
			$userInstance = \App\User::getUser();
			$userInstance->set('language', $request->get('lang'));
		}
		return $request;
	}

	/*
	 * public function getHeaderCss(\App\Request $request)
	 * {
	 * $parentScripts = parent::getHeaderCss($request);
	 * $cssFileNames = [
	 * 'libraries/Bootstrap/css/bootstrap.css',
	 * 'libraries/Bootstrap/css/bootstrap-theme.css',
	 * 'layouts/' . \App\Viewer::getLayoutName() . '/skins/basic/styles.css',
	 * ];.
	 *
	 * $addScripts = $this->convertScripts($cssFileNames, 'css');
	 * $parentScripts = array_merge($parentScripts, $addScripts);
	 * return $parentScripts;
	 * }
	 *
	 * public function getFooterScripts(\App\Request $request)
	 * {
	 * $parentScripts = parent::getFooterScripts($request);
	 * $jsFileNames = [
	 * 'libraries/Scripts/jquery/jquery.js',
	 * ];
	 * $addScripts = $this->convertScripts($jsFileNames, 'js');
	 * $parentScripts = array_merge($parentScripts, $addScripts);
	 * return $parentScripts;
	 * }
	 */
}
