<?php
/**
 * PDF view modal.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Pdf class.
 */
class Pdf extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	protected function getTitle()
	{
		return \App\Language::translate('LBL_AVAILABLE_PDF_TEMPLATES', $this->request->getModule());
	}

	/** {@inheritdoc} */
	protected function getModalSize()
	{
		return 'modal-md';
	}

	/** {@inheritdoc} */
	protected function getModalIcon(): string
	{
		return 'fas fa-file-pdf';
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$recordId = $this->request->getInteger('record');
		$this->viewer->assign('TEMPLATES', \App\Pdf::getTemplates($this->moduleName, $recordId));
		$this->viewer->assign('RECORD_ID', $recordId);
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/** {@inheritdoc} */
	public function postProcessAjax()
	{
	}

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'Modal/Pdf.tpl';
	}
}
