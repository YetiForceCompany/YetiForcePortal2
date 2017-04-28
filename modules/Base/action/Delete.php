<?php
/**
 * Delete Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Modules\Base\Action;

use YF\Core;

class Delete extends Base
{

	/**
	 * Process
	 * @param \YF\Core\Request $request
	 * @return mixed
	 */
	public function process(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$result = false;
		if ($record) {
			$api = \YF\Core\Api::getInstance();
			$result = $api->call($module . '/Record/' . $record, [], 'delete');
		}
		if ($request->isAjax()) {
			$response = new \YF\Core\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			return $result;
		}
	}
}
