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
	/** @var \YF\Modules\Base\Model\ListView List view model. */
	protected $listViewModel;

	/** {@inheritdoc} */
	public function process()
	{
		$this->getListViewModel()->loadRecordsList();
		$moduleName = $this->request->getModule();
		$this->viewer->assign('HEADERS', $this->listViewModel->getHeaders());
		$this->viewer->assign('RECORDS', $this->listViewModel->getRecordsListModel());
		$this->viewer->assign('COUNT', $this->listViewModel->getCount());
		$this->viewer->assign('PAGE_NUMBER', 11);
		$this->viewer->assign('LIST_VIEW_MODEL', $this->listViewModel);
		$this->viewer->view('List/ListView.tpl', $moduleName);
	}

	/**
	 * Get list view model.
	 *
	 * @return \YF\Modules\Base\Model\ListView
	 */
	protected function getListViewModel(): \YF\Modules\Base\Model\ListView
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = \YF\Modules\Base\Model\ListView::getInstance($this->moduleName, $this->request->getAction());
		}
		return $this->listViewModel;
	}
}
