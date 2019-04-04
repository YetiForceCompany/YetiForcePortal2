<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use App\Request;
use YF\Modules\Base\Model\ListView as ListViewModel;

class RecordList extends \App\Controller\Modal
{
	/**
	 * {@inheritdoc}
	 */
	public function process(Request $request)
	{
		$moduleName = $request->getModule();
		$listViewModel = ListViewModel::getInstance($moduleName)->loadRecordsList();
		$viewer = $this->getViewer($request);
		$viewer->assign('HEADERS', $listViewModel->getHeaders());
		$viewer->assign('RECORDS', $listViewModel->getRecordsListModel());
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('COUNT', $listViewModel->getCount());
		$viewer->view($this->processTplName($request), $moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	public function processTplName(Request $request = null): string
	{
		return 'RecordList/RecordList.tpl';
	}
}
