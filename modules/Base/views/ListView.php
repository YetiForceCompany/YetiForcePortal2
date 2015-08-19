<?php
/**
 * List view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;

use Core;

class ListView extends Index
{

	public function process(Core\Request $request)
	{
		$module = $request->getModule();
		$api = Core\Api::getInstance();
		$recordsList = $api->call($module . '/GetRecordsList', [], 'get');


		$viewer = $this->getViewer($request);
		$viewer->assign('HEADERS', $recordsList['headers']);
		$viewer->assign('RECORDS', $recordsList['records']);
		$viewer->assign('COUNT', $recordsList['count']);
		$viewer->view('ListView.tpl', $module);
	}
}
