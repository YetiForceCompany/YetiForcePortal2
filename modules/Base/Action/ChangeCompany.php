<?php
/**
 * Delete action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

class ChangeCompany extends \App\Controller\Action
{
	/**
	 * Process.
	 *
	 * @param \App\Request $request
	 *
	 * @return mixed
	 */
	public function process(\App\Request $request)
	{
		$userInstance = \App\User::getUser();
		$userInstance->set('CompanyId', $request->get('record'));
		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}
}
