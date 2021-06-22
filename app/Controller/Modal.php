<?php
/**
 * Controller file for views.
 *
 * @package   Controller
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

/**
 * Controller class for views.
 */
abstract class Modal extends View
{
	/** @var string The name of the success button. */
	public $successBtn = 'BTN_SAVE';

	/** @var string The name of the success button icon. */
	public $successBtnIcon = 'fas fa-check';

	/** @var string The name of the danger button. */
	public $dangerBtn = 'BTN_CANCEL';

	/** @var string The name of the footerClass. */
	public $footerClass = '';

	/** @var bool Block the window closing. */
	public $lockExit = false;

	/** @var bool Show modal footer. */
	public $showFooter = true;

	/** {@inheritdoc} */
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

	/** {@inheritdoc} */
	public function preProcessAjax()
	{
		$this->viewer->assign('MODAL_SIZE', $this->getModalSize());
		$this->viewer->assign('MODAL_CSS', $this->getModalCss());
		$this->viewer->assign('MODAL_JS', $this->getModalJs());
		$this->viewer->assign('MODAL_TITLE', $this->getTitle());
		$this->viewer->assign('MODAL_ICON', $this->getModalIcon());
		$this->viewer->assign('VIEW', $this->request->getAction());
		$this->viewer->assign('LOCK_EXIT', $this->lockExit);
		$this->viewer->view('Modal/Header.tpl');
	}

	/** {@inheritdoc} */
	public function postProcessAjax()
	{
		if ($this->showFooter()) {
			$this->viewer->assign('BTN_SUCCESS', $this->successBtn);
			$this->viewer->assign('BTN_SUCCESS_ICON', $this->successBtnIcon);
			$this->viewer->assign('BTN_DANGER', $this->dangerBtn);
			$this->viewer->assign('FOOTER_CLASS', $this->footerClass);
			$this->viewer->view('Modal/Footer.tpl');
		}
	}

	/** {@inheritdoc} */
	protected function showFooter(): bool
	{
		return $this->showFooter;
	}

	/**
	 * Retrieves css styles that need to loaded in the page.
	 *
	 * @return \App\Script[]
	 */
	protected function getModalCss(): array
	{
		return $this->convertScripts([], 'css');
	}

	/**
	 * Scripts.
	 *
	 * @return \App\Script[]
	 */
	protected function getModalJs(): array
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		return $this->convertScripts([
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/{$action}.js", true],
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js", true],
		], 'js');
	}
}
