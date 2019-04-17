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

	public function checkPermission()
	{
		return true;
	}

	public function preProcess($display = true)
	{
		$module = $this->request->getModule();
		$viewer = $this->getViewer();
		$this->setLanguage();
		parent::preProcess($display);
		$viewer->view('InstallPreProcess.tpl', $module);
	}

	public function process()
	{
		$module = $this->request->getModule();
		$mode = $this->request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			return $this->{$mode}();
		}
		$this->Step1($this->request);
	}

	public function Step1()
	{
		$module = $this->request->getModule();
		$viewer = $this->getViewer($this->request);
		$viewer->view('InstallStep1.tpl', $module);
	}

	public function Step2()
	{
		$module = $this->request->getModule();
		$viewer = $this->getViewer();
		$viewer->view('InstallStep2.tpl', $module);
	}

	public function postProcess($display = true)
	{
		$module = $this->request->getModule();
		$viewer = $this->getViewer();
		$viewer->view('InstallPostProcess.tpl', $module);
		parent::postProcess($display);
	}

	public function setLanguage()
	{
		if ($this->request->get('lang')) {
			$userInstance = \App\User::getUser();
			$userInstance->set('language', $this->request->get('lang'));
		}
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
