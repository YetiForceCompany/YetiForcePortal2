<?php
/**
 * Edit view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Edit view class.
 */
class EditView extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$actionName = 'EditView';
		if ($this->request->isEmpty('record')) {
			$actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), $actionName)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		if ($this->request->isEmpty('record')) {
			$recordModel = \YF\Modules\Base\Model\Record::getInstance($moduleName);
		} else {
			$recordModel = \YF\Modules\Base\Model\Record::getInstanceById($moduleName, $this->request->getInteger('record'), ['x-raw-data' => 1]);
		}
		$moduleModel = $recordModel->getModuleModel();
		$this->viewer->assign('RECORD', $recordModel);
		$this->viewer->assign('FIELDS', $moduleModel->getFieldsModels());
		$this->viewer->assign('FIELDS_FORM', $moduleModel->getFormFields());
		$this->viewer->assign('BLOCKS', $moduleModel->getBlocks());
		$this->viewer->assign('BREADCRUMB_TITLE', $recordModel->getName());
		$this->viewer->view('Edit/EditView.tpl', $moduleName);
	}

	/** {@inheritdoc} */
	public function getFooterScripts(bool $loadForModule = true): array
	{
		$files = [
			['layouts/' . \App\Viewer::getLayoutName() . '/modules/Base/resources/EditView.js'],
		];
		if ($loadForModule) {
			$files[] = ['layouts/' . \App\Viewer::getLayoutName() . '/modules/' . $this->getModuleNameFromRequest() . '/resources/EditView.js', true];
		}
		return array_merge(
			parent::getFooterScripts($loadForModule),
			$this->convertScripts($files, 'js')
		);
	}
}
