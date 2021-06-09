<?php
/**
 * Records list view file.
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
 * Records list view class.
 */
class ListView extends \App\Controller\View
{
	/** {@inheritdoc} */
	public function process()
	{
		$listViewModel = \YF\Modules\Base\Model\ListView::getInstance($this->moduleName, $this->request->getAction());
		$this->viewer->assign('HEADERS', $listViewModel->getHeaders());
		$this->viewer->assign('LIST_VIEW_MODEL', $listViewModel);
		$this->viewer->view($this->processTplName(), $this->moduleName);
	}

	/** {@inheritdoc} */
	protected function processTplName(): string
	{
		return 'List/ListView.tpl';
	}
}
