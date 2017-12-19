<?php
/**
 * Delete action class
 * @package YetiForce.Actions
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
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
