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
	public function checkPermission(\App\Request $request)
	{
		$moduleName = $request->getModule();
		$userInstance = \App\User::getUser();
		$modulePermission = $userInstance->isPermitted($moduleName);
		if (!$modulePermission) {
			throw new \App\AppException('LBL_MODULE_PERMISSION_DENIED');
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcess(\App\Request $request)
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function postProcess(\App\Request $request)
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function postProcessAjax(\App\Request $request)
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function preProcessAjax(\App\Request $request)
	{
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateRequest()
	{
		$this->request->validateWriteAccess();
	}
}
