<?php
/**
 * Save action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

class Pdf extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function checkPermission()
	{
		if (!\YF\Modules\Base\Model\Module::isPermitted($this->request->getModule(), 'ExportPdf')) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$templates = $this->request->getArray('templates', Purifier::INTEGER);
		$result = \App\Api::getInstance()->call($moduleName . '/Pdf/' . $record . '?templates=' . \App\Json::encode($templates));
		if (!empty($result)) {
			$fileName = $result['name'];
			header('accept-charset: utf-8');
			header('content-type: application/octet-stream; charset=utf-8');
			header("content-disposition: attachment; filename=\"{$fileName}\"");
			echo \base64_decode($result['data']);
		} else {
			echo '<script>window.close();</script>';
		}
	}
}
