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
	protected function getTitle()
	{
		return \App\Language::translateModule($this->request->getModule());
	}

	protected function getModalSize()
	{
		return 'modal-xl';
	}

	/**
	 * Modal icon.
	 *
	 * @return string
	 */
	protected function getModalIcon(): string
	{
		return '';
	}

	public function preProcessAjax()
	{
		$this->viewer->assign('MODAL_SIZE', $this->getModalSize());
		$this->viewer->assign('MODAL_CSS', $this->getModalCss());
		$this->viewer->assign('MODAL_JS', $this->getModalJs());
		$this->viewer->assign('MODAL_TITLE', $this->getTitle());
		$this->viewer->assign('MODAL_ICON', $this->getModalIcon());
		$this->viewer->assign('VIEW', $this->request->getAction());
		$this->viewer->view('Modal/Header.tpl');
	}

	public function postProcessAjax()
	{
		$this->viewer->view('Modal/Footer.tpl');
	}

	protected function getModalCss()
	{
		return $this->convertScripts([], 'css');
	}

	/** {@inheritdoc} */
	protected function getModalJs()
	{
		$action = $this->request->getAction();
		return $this->convertScripts([
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/$action.js"],
		], 'js');
	}
}
