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
		$response = $api->call($module . '/Fields', [], 'get');

		$blocks = $fields = [];
		foreach ($response['blocks'] as &$block) {
			$blocks[$block['sequence']] = $block;
		}
		foreach ($response['fields'] as &$field) {
			$fields[$field['blockId']][$field['sequence']] = $field;
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('FIELDS', $fields);
		$viewer->assign('BLOCKS', $blocks);
		$viewer->view('EditView.tpl', $module);
	}
}
