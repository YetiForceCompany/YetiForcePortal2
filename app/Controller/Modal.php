<?php
/**
 * Controller class for views.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Controller;

abstract class Modal extends View
{
	protected function getTitle(\App\Request $request)
	{
		return \App\Language::translateModule($request->getModule());
	}

	protected function getModalSize()
	{
		return 'modal-lg';
	}

	public function preProcessAjax(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->assign('MODAL_SIZE', $this->getModalSize($request));
		$viewer->assign('MODAL_CSS', $this->getModalCss($request));
		$viewer->assign('MODAL_JS', $this->getModalJs($request));
		$viewer->assign('MODAL_TITLE', $this->getTitle($request));
		$viewer->assign('VIEW', $request->getAction());
		$viewer->view('Modal/Header.tpl');
	}

	public function postProcessAjax(\App\Request $request)
	{
		$viewer = $this->getViewer($request);
		$viewer->view('Modal/Footer.tpl');
	}

	protected function getModalCss(\App\Request $request)
	{
		$cssFileNames = [
		];

		return $this->convertScripts($cssFileNames, 'css');
	}

	protected function getModalJs(\App\Request $request)
	{
		$action = $request->getAction();
		$jsFileNames = [
			YF_ROOT_WWW . 'layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/$action.js",
		];

		return $this->convertScripts($jsFileNames, 'js');
	}
}
