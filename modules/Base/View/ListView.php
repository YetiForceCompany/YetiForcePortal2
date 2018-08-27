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

class ListView extends Index
{
	public function process(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$api = \YF\Core\Api::getInstance();
		$recordsListModel = [];
		$recordsList = $api->call($module . '/RecordsList');
		if (!empty($recordsList['records'])) {
			foreach ($recordsList['records'] as $key => $value) {
				$recordModel = \YF\Modules\Base\Model\Record::getInstance($module);
				$recordModel->setData($value)->setId($key);
				$recordsListModel[$key] = $recordModel;
			}
		}
		$viewer = $this->getViewer($request);
		if (!isset($recordsList['headers'])) {
			$recordsList['headers'] = [];
		}
		$viewer->assign('HEADERS', $recordsList['headers']);
		$viewer->assign('RECORDS', $recordsListModel);
		$viewer->assign('MODULE_NAME', $module);
		if (!isset($recordsList['count'])) {
			$recordsList['count'] = 0;
		}
		$viewer->assign('COUNT', $recordsList['count']);
		$viewer->view('ListView.tpl', $module);
	}
}
