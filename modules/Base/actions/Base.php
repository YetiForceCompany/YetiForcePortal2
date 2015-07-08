<?php

/**
 * Abstract Action Controller Class
 */
abstract class Base_Action_Base extends Core_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function getViewer(Core_Viewer $request)
	{
		throw new PortalException('Action - implement getViewer - JSONViewer');
	}

	public function validateRequest(Core_Viewer $request)
	{
		return $request->validateReadAccess();
	}

	public function preProcess(Core_Viewer $request)
	{
		return true;
	}

	public function postProcess(Core_Viewer $request)
	{
		return true;
	}
}
