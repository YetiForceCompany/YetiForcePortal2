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
	public function validateRequest(\App\Request $request)
	{
		$request->validateWriteAccess();
	}
}
