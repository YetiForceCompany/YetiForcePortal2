<?php
/**
 * PDF action file.
 *
 * @package Action
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

/**
 * PDF action class.
 */
class Pdf extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), 'ExportPdf')) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$moduleName = $this->request->getModule();
		$record = $this->request->getByType('record', Purifier::INTEGER);
		$templates = $this->request->getArray('templates', Purifier::INTEGER);
		$result = \App\Api::getInstance()->call($moduleName . '/Pdf/' . $record . '?templates=' . \App\Json::encode($templates));
		if (!empty($result)) {
			$fileName = $result['name'];
			header('accept-charset: utf-8');
			header('content-type: application/pdf; charset=utf-8');
			header("content-disposition: inline; filename=\"{$fileName}\"");
			echo \base64_decode($result['data']);
		} else {
			echo '<script>window.close();</script>';
		}
	}
}
