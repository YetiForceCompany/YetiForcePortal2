<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use YF\Modules\Base\Model\ListView as ListViewModel;

class ListView extends \App\Controller\View
{
	/**
	 * List view model.
	 *
	 * @var ListViewModel
	 */
	protected $listViewModel;

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$this->getListViewModel()->loadRecordsList();
		$moduleName = $this->request->getModule();
		$this->viewer->assign('HEADERS', $this->listViewModel->getHeaders());
		$this->viewer->assign('RECORDS', $this->listViewModel->getRecordsListModel());
		$this->viewer->assign('MODULE_NAME', $moduleName);
		$this->viewer->assign('COUNT', $this->listViewModel->getCount());
		$this->viewer->assign('LIST_VIEW_MODEL', $this->listViewModel);
		$this->viewer->assign('USER', \App\User::getUser());
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function processTplName(): string
	{
		return 'ListView.tpl';
	}

	/**
	 * Get list view model.
	 *
	 * @return self
	 */
	protected function getListViewModel()
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = ListViewModel::getInstance($this->moduleName);
		}
		return $this->listViewModel;
	}
}
