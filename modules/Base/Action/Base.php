<?php
/**
 * Abstract action controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Base\Action;

abstract class Base extends \App\Controller
{
	public function getViewer(\App\Request $request)
	{
		throw new \App\AppException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(\App\Request $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(\App\Request $request)
	{
		return true;
	}

	public function postProcess(\App\Request $request)
	{
		return true;
	}

	public function checkPermission(\App\Request $request)
	{
		return true;
	}
}
