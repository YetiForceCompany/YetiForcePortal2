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
	 * {@inheritdoc}
	 */
	public function checkPermission(\App\Request $request)
	{
		if (!\YF\Modules\Base\Model\Module::isPermitted($request->getModule(), 'Delete')) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
	}

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
		$result = false;
		if ($record) {
			$api = \App\Api::getInstance();
			$result = $api->call($module . '/Record/' . $record, [], 'delete');
		}
		if ($request->isAjax()) {
			$response = new \App\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			return $result;
		}
	}
}
