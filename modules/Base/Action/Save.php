<?php
/**
 * Save action class.
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
		$moduleName = $this->request->getModule();
		$record = $this->request->isEmpty('record') ? '' : $this->request->getByType('record', Purifier::INTEGER);
		$api = \App\Api::getInstance();
		$formData = $this->request->getAllRaw();
		$moduleModel = \YF\Modules\Base\Model\Module::getInstance($moduleName);
		foreach ($moduleModel->getFieldsModels() as $fieldModel) {
			$fieldModel->setApiData($this->request, $api);
		}
		$formData = array_diff_key($formData, $moduleModel->getFieldsModels());
		unset($formData['_csrf'], $formData['_fromView'], $formData['action']);
		$result = $api->call($moduleName . '/Record/' . $record, $formData, $record ? 'put' : 'post');
		if ($this->request->isEmpty('record')) {
			$record = $result['id'] ?? '';
		}
		if ($this->request->isAjax()) {
			$response = new \App\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			$view = $this->request->has('_fromView') ? $this->request->getByType('_fromView', Purifier::ALNUM) : 'DetailView';
			header("Location:index.php?module={$moduleName}&view={$view}&record={$record}");
		}
	}
}
