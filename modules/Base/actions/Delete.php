<?php
/**
 * Delete Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\Action;

use Core;

class Delete extends Base
{

	/**
	 * Process
	 * @param Core\Request $request
	 * @return mixed
	 */
	public function process(Core\Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		;
		$result = false;
		if ($record) {
			$api = Core\Api::getInstance();
			$result = $api->call($module . '/Record/' . $record, [], 'delete');
		}
		if ($request->isAjax()) {
			$response = new Core\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			return $result;
		}
	}
}
