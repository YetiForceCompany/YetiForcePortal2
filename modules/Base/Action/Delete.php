<?php
/**
 * Delete action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

class Delete extends Base
{
	/**
	 * Process.
	 *
	 * @param \YF\Core\Request $request
	 *
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
