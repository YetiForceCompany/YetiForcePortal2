<?php
/**
 * Delete action class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

use App\Purifier;

class ChangeCompany extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$userInstance = \App\User::getUser();
		$userInstance->set('CompanyId', $this->request->getByType('record', Purifier::INTEGER));
		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}
}
