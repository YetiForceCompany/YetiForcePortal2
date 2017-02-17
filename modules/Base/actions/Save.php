<?php
/**
 * Save Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\Action;

use Core;

class Save extends Base
{

	/**
	 * Process
	 * @param Core\Request $request
	 * @return mixed
	 */
	public function process(Core\Request $request)
	{
		$module = $request->getModule();
		$record = $request->get('record');
		$view = $request->get('view');
		$api = Core\Api::getInstance();
		$result = $api->call($module . '/Record/' . $record, ['recordData' => $request->getAll()], $record ? 'put' : 'post');
		if ($request->isAjax()) {
			$response = new Core\Response();
			$response->setResult($result);
			$response->emit();
		} else {
			header("Location:index.php?module=$module&view=$view&record=$record");
		}
	}
}
