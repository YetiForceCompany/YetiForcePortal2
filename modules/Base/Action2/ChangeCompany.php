<?php
/**
 * Delete Action Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
namespace YF\Modules\Base\Action;

use YF\Core;

class ChangeCompany extends Base
{

	/**
	 * Process
	 * @param \YF\Core\Request $request
	 * @return mixed
	 */
	public function process(\YF\Core\Request $request)
	{
		$userInstance = \YF\Core\User::getUser();
		$userInstance->set('CompanyId', $request->get('record'));

		$response = new \YF\Core\Response();
		$response->setResult(true);
		$response->emit();
	}
}
