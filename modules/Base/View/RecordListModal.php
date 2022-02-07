<?php
/**
 * Record list modal view file.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Record list modal view class.
 */
class RecordListModal extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public $successBtn = '';

	/** {@inheritdoc} */
	protected function getModalSize(): string
	{
		return 'modal-fullscreen';
	}

	/** {@inheritdoc} */
	protected function getModalIcon(): string
	{
		return "yfm-{$this->request->getModule()}";
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$listModel = \YF\Modules\Base\Model\RecordList::getInstance($moduleName, 'RecordList');
		$this->viewer->assign('HEADERS', $listModel->getHeaders());
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'RecordListModal/RecordList.tpl';
	}
}
