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
		$respons = $api->call($module . '/GetRecordsList', [], 'get');


		$viewer = $this->getViewer($request);
		$viewer->assign('HEADER', Core\Language::getLanguage());
		$viewer->assign('RECORDS', Core\Language::getLanguage());
		$viewer->view('ListView.tpl', $module);
	}
}
