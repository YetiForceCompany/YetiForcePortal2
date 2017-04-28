<?php
/**
 * List view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\View;

use Core;

class ListView extends Index
{

	public function process(Core\Request $request)
	{
		$module = $request->getModule();
		$api = Core\Api::getInstance();
		$recordsListModel = [];
		$recordsList = $api->call($module . '/RecordsList');
		if (!empty($recordsList['records'])) {
			foreach ($recordsList['records'] as $key => $value) {
				$recordModel = \Base\Model\Record::getInstance($module);
				$recordModel->setData($value)->setId($key);
				$recordsListModel[$key] = $recordModel;
			}
		}
		$viewer = $this->getViewer($request);
		if (!isset($recordsList['headers'])) {
			$recordsList['headers'] = array();
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
