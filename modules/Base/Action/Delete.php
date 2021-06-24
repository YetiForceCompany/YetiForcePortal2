<?php
/**
 * Delete record action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

/**
 * Delete record action class.
 */
class Delete extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), 'Delete')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$module = $this->request->getModule();
		$record = $this->request->getInteger('record');
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
			header('Refresh:0');
		}
	}
}
