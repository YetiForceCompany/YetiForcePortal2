<?php
/**
 * List view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;

use Core;

class DetailView extends Index
{

	public function process(Core\Request $request)
	{
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$api = Core\Api::getInstance();
		$recordDetail = $api->call($moduleName . '/Record/' . $record, [], 'get');

		$viewer = $this->getViewer($request);
		$viewer->assign('BREADCRUMB_TITLE', $recordDetail['name']);
		$viewer->assign('DETAIL', $recordDetail['data']);
		$viewer->view('DetailView.tpl', $moduleName);
	}
}
