<?php
/**
 * File action file.
 *
 * @package Action
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

/**
 * File action class.
 */
class File extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateReadAccess();
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$moduleName = $this->request->getModule();
		$data = [
			'module' => $moduleName,
			'actionName' => $this->request->getByType('actionName'),
			'record' => $this->request->getInteger('record'),
			'key' => $this->request->getInteger('key')
		];

		$result = \App\Api::getInstance()->setCustomHeaders(['Accept' => $this->request->get('type')])->call('Files', $data, 'put');
		if (!empty($result)) {
			$fileName = $this->request->get('name');
			header('content-type: ' . $this->request->get('type'));
			header('pragma: public');
			header('cache-control: private');
			header("content-disposition: attachment; filename=\"$fileName\"");
			echo $result;
		} else {
			echo '<script>window.close();</script>';
		}
	}
}
