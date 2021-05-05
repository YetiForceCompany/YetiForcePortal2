<?php
/**
 * Abstract action controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 */

namespace App\Controller;

abstract class Action extends Base
{
	/**
	 * Check permission.
	 *
	 * @return bool
	 */
	public function checkPermission()
	{
		$moduleName = $this->request->getModule();
		$userInstance = \App\User::getUser();
		$modulePermission = $userInstance->isPermitted($moduleName);
		if (!$modulePermission) {
			throw new \App\Exceptions\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	/** {@inheritdoc} */
	public function preProcess()
	{
	}

	/** {@inheritdoc} */
	public function postProcess()
	{
	}

	/** {@inheritdoc} */
	public function postProcessAjax()
	{
	}

	/** {@inheritdoc} */
	public function preProcessAjax()
	{
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateWriteAccess();
	}
}
