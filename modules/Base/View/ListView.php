<?php
/**
 * Records list view file.
 *
 * @package View
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

/**
 * Records list view class.
 */
class ListView extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function process()
	{
		$moduleModel = \YF\Modules\Base\Model\Module::getInstance($this->moduleName);
		$listViewModel = \YF\Modules\Base\Model\ListView::getInstance($this->moduleName, $this->request->getAction());
		if ($this->request->has('cvId')) {
			$listViewModel->setCvId($this->request->getByType('cvId', \App\Purifier::INTEGER));
		}
		$this->viewer->assign('FIELDS', $moduleModel->getFieldsModels());
		$this->viewer->assign('CUSTOM_VIEWS', $listViewModel->getCustomViews());
		$this->viewer->assign('VIEW_ID', $listViewModel->getDefaultCustomView());
		$this->viewer->assign('HEADERS', $listViewModel->getHeaders());
		$this->viewer->view($this->processTplName(), $this->moduleName);
	}

	/** {@inheritdoc} */
	protected function processTplName(): string
	{
		return 'List/ListView.tpl';
	}
}
