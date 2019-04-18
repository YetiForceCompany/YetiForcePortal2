<?php
/**
 * Delete action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

class Delete extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function checkPermission()
	{
		if (!\YF\Modules\Base\Model\Module::isPermitted($this->request->getModule(), 'Delete')) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$module = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$result = false;
		if ($record) {
			$api = \App\Api::getInstance();
			$result = $api->call($module . '/Record/' . $record, [], 'delete');
		}
		if ($this->request->isAjax()) {
			$response = new \App\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			return $result;
		}
	}
}
