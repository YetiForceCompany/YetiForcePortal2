<?php
/**
 * Edit view class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\View;
use Core\Request;
use Core\Api;
class EditView extends Index
{
	public function process(Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$api = Api::getInstance();
		$recordDetail = $api->call($module . '/GetRecordDetail/'.$record, [], 'get');		
		$viewer = $this->getViewer($request);
		$viewer->assign('DETAIL', $recordDetail['data']);
		$viewer->view('EditView.tpl', $module);
	}
}
