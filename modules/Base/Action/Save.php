<?php
/**
 * Save action class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Modules\Base\Action;

use YF\Core;

class Save extends Base
{

	/**
	 * Process
	 * @param \YF\Core\Request $request
	 * @return mixed
	 */
	public function process(\YF\Core\Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$view = $request->get('view');
		$api = \YF\Core\Api::getInstance();
		$result = $api->call($module . '/Record/' . $record, $request->getAll(), $record ? 'put' : 'post');
		if ($request->isAjax()) {
			$response = new \YF\Core\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			header("Location:index.php?module=$module&view=$view&record=$record");
		}
	}
}
