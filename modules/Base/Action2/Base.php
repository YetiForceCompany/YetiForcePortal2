<?php
/**
 * Abstract Action Controller Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace YF\Modules\Base\Action;

use YF\Core;

abstract class Base extends \YF\Core\Controller
{

	public function getViewer(\YF\Core\Request $request)
	{
		throw new AppException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(\YF\Core\Request $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(\YF\Core\Request $request)
	{
		return true;
	}

	public function postProcess(\YF\Core\Request $request)
	{
		return true;
	}

	public function checkPermission()
	{
		return true;
	}
}
