<?php
/**
 * Change company action file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author	Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

/**
 * Change company action class.
 */
class ChangeCompany extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
		parent::checkPermission();
		$companies = \App\User::getUser()->getCompanies();
		if (!isset($companies[$this->request->getInteger('record')])) {
			throw new \App\Exceptions\NoPermitted('ERR_ACTION_PERMISSION_DENIED');
		}
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$user = \App\User::getUser();
		$user->set('companyId', $this->request->getInteger('record'));
		$companies = $user->getCompanies();
		$user->set('parentName', $companies[$this->request->getInteger('record')]['name']);

		$response = new \App\Response();
		$response->setResult(true);
		$response->emit();
	}
}
