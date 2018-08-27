<?php
/**
 * Save action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

class Save extends Base
{
	/**
	 * Process.
	 *
	 * @param \App\Request $request
	 *
	 * @return mixed
	 */
	public function process(\App\Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$view = $request->get('view');
		$api = \App\Api::getInstance();
		$result = $api->call($module . '/Record/' . $record, $request->getAll(), $record ? 'put' : 'post');
		if ($request->isAjax()) {
			$response = new \App\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			header("Location:index.php?module=$module&view=$view&record=$record");
		}
	}
}
