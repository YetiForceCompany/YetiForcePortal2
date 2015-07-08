<?php

/**
 * Abstract Action Controller Class
 */
abstract class Base_Action_Base extends Core_Controller
{

	public function getViewer(Core_Request $request)
	{
		throw new PortalException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(Core_Request $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(Core_Request $request)
	{
		return true;
	}

	public function postProcess(Core_Request $request)
	{
		return true;
	}
}
