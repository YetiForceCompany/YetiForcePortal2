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

use App\Request;
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
	public function preProcess(Request $request, $display = true)
	{
		parent::preProcess($request, $display);
		$this->getListViewModel($request->getModule());
	}

	/**
	 * {@inheritdoc}
	 */
	public function process(Request $request)
	{
		$this->listViewModel->loadRecordsList();
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->assign('HEADERS', $this->listViewModel->getHeaders());
		$viewer->assign('RECORDS', $this->listViewModel->getRecordsListModel());
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('COUNT', $this->listViewModel->getCount());
		$viewer->view($this->processTplName($request), $moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	public function processTplName(Request $request = null): string
	{
		return 'ListView.tpl';
	}

	/**
	 * Get list view model.
	 *
	 * @param string $moduleName
	 *
	 * @return ListViewModel
	 */
	protected function getListViewModel(string $moduleName): ListViewModel
	{
		if (empty($this->listViewModel)) {
			$this->listViewModel = ListViewModel::getInstance($moduleName);
		}
		return $this->listViewModel;
	}
}
