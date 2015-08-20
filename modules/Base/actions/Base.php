<?php
/**
 * Abstract Action Controller Class
 * @package YetiForce.Actions
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
namespace Base\Action;

use Core;

abstract class Base extends Core\Controller
{

	public function getViewer(Core\Request $request)
	{
		throw new AppException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(Core\Request $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(Core\Request $request)
	{
		return true;
	}

	public function postProcess(Core\Request $request)
	{
		return true;
	}
	
	public function checkPermission()
	{
		return true;
	}
}
