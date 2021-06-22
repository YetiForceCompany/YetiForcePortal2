<?php
/**
 * Abstract action controller class.
 *
 * @package   Controller
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Tomasz Kur <t.kur@yetiforce.com>
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

abstract class Action extends Base
{
	/**
	 * Check permission.
	 *
	 * @throws \App\Exceptions\NoPermitted
	 *
	 * @return void
	 */
	public function checkPermission(): void
	{
		if (!\App\User::getUser()->isPermitted($this->request->getModule())) {
			throw new \App\Exceptions\NoPermitted('ERR_MODULE_PERMISSION_DENIED');
		}
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
