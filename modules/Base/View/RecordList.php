<?php
/**
 * List view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace YF\Modules\Base\View;

use YF\Modules\Base\Model\ListView as ListViewModel;

class RecordList extends \App\Controller\Modal
{
	/** {@inheritdoc} */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$listViewModel = ListViewModel::getInstance($moduleName)->loadRecordsList();
		$this->viewer->assign('HEADERS', $listViewModel->getHeaders());
		$this->viewer->assign('RECORDS', $listViewModel->getRecordsListModel());
		$this->viewer->assign('COUNT', $listViewModel->getCount());
		$this->viewer->view($this->processTplName(), $moduleName);
	}

	/** {@inheritdoc} */
	public function processTplName(): string
	{
		return 'RecordList/RecordList.tpl';
	}
}
