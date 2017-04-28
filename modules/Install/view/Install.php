<?php
/**
 * Install view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Install\View;

use YF\Modules\Base\View,
	YF\Core;

class Install extends View\Index
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

	public function checkPermission(\YF\Core\Request $request)
	{
		return true;
	}

	public function preProcess(\YF\Core\Request $request, $display = true)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$request = $this->setLanguage($request);
		parent::preProcess($request, $display);
		$viewer->view('InstallPreProcess.tpl', $module);
	}

	public function process(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$mode = $request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			return $this->$mode($request);
		}
		$this->Step1($request);
	}

	public function Step1(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallStep1.tpl', $module);
	}

	public function Step2(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallStep2.tpl', $module);
	}

	public function postProcess(\YF\Core\Request $request, $display = true)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('InstallPostProcess.tpl', $module);
		parent::postProcess($request, $display);
	}

	public function setLanguage($request)
	{
		if ($request->get('lang')) {
			$userInstance = \YF\Core\User::getUser();
			$userInstance->set('language', $request->get('lang'));
		}
		return $request;
	}
	/**

	  public function getHeaderCss(\YF\Core\Request $request)
	  {
	  $parentScripts = parent::getHeaderCss($request);
	  $cssFileNames = [
	  'libraries/Bootstrap/css/bootstrap.css',
	  'libraries/Bootstrap/css/bootstrap-theme.css',
	  'layouts/' . \YF\Core\Viewer::getLayoutName() . '/skins/basic/styles.css',
	  ];

	  $addScripts = $this->convertScripts($cssFileNames, 'css');
	  $parentScripts = array_merge($parentScripts, $addScripts);
	  return $parentScripts;
	  }

	  public function getFooterScripts(\YF\Core\Request $request)
	  {
	  $parentScripts = parent::getFooterScripts($request);
	  $jsFileNames = [
	  'libraries/Scripts/jquery/jquery.js',
	  ];
	  $addScripts = $this->convertScripts($jsFileNames, 'js');
	  $parentScripts = array_merge($parentScripts, $addScripts);
	  return $parentScripts;
	  }
	 */
}
