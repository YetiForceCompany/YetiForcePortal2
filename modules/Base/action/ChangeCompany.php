<?php
/**
 * Delete Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace Base\Action;

use Core;

class ChangeCompany extends Base
{

	/**
	 * Process
	 * @param Core\Request $request
	 * @return mixed
	 */
	public function process(Core\Request $request)
	{
		$userInstance = Core\User::getUser();
		$userInstance->set('CompanyId', $request->get('record'));

		$response = new Core\Response();
		$response->setResult(true);
		$response->emit();
	}
}
