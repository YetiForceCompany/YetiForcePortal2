<?php
/**
 * Quick create view modal file.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Quick create view modal class.
 */
class QuickCreateModal extends \App\Controller\Modal
{
	use \App\Controller\EditViewTrait;

	/** {@inheritdoc} */
	public $showFooter = false;

	/** @var string Action name */
	protected $actionName = 'CreateView';

	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), 'CreateView')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	protected function getTitle()
	{
		return \App\Language::translate('LBL_VIEW_QUICK_CREATE', $this->request->getModule()) . ' - ' . \App\Language::translateModule($this->request->getModule());
	}

	/** {@inheritdoc} */
	protected function getModalSize()
	{
		return 'c-modal-xxl';
	}

	/** {@inheritdoc} */
	protected function getModalIcon(): string
	{
		return 'yfm-' . $this->request->getModule();
	}

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'Modal/QuickCreate.tpl';
	}

	/** {@inheritdoc} */
	public function getModalJs(bool $loadForModule = true): array
	{
		$moduleName = $this->getModuleNameFromRequest();
		$action = $this->request->getAction();
		$files = [
			['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
			['layouts/' . \App\Viewer::getLayoutName() . "/modules/Base/resources/{$action}.js", true],
		];
		if ($loadForModule) {
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . '/modules/' . $this->getModuleNameFromRequest() . '/resources/EditView.js', true];
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . "/modules/{$moduleName}/resources/{$action}.js", true];
		}
		return $this->convertScripts($files, 'js');
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateWriteAccess();
	}
}
