<?php

class Users_View_Login extends Base_View_Base
{

	function loginRequired()
	{
		return false;
	}

	function checkPermission(Core_Request $request)
	{
		return true;
	}

	function process(Core_Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('Login.tpl', $module);
	}
}
