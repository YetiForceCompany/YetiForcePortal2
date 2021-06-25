<?php
/**
 * Save action class.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

class Save extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		$actionName = 'EditView';
		if ($this->request->isEmpty('record')) {
			$actionName = 'CreateView';
		}
		if (!\YF\Modules\Base\Model\Module::isPermittedByModule($this->request->getModule(), $actionName)) {
			throw new \App\Exceptions\AppException('ERR_MODULE_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		$module = $this->request->getModule();
		$record = $this->request->isEmpty('record') ? '' : $this->request->getByType('record', Purifier::INTEGER);
		$formData = $this->request->getAllRaw();
		unset($formData['_csrf'], $formData['_fromView']);
		$result = \App\Api::getInstance()->call($module . '/Record/' . $record, $formData, $record ? 'put' : 'post');
		if ($this->request->isEmpty('record')) {
			$record = $result['id'] ?? '';
		}
		if ($this->request->isAjax()) {
			$response = new \App\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			$view = $this->request->has('_fromView') ? $this->request->getByType('_fromView', Purifier::ALNUM) : 'DetailView';
			header("Location:index.php?module=$module&view={$view}&record=$record");
		}
	}
}
