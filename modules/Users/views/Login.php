<?php

class Users_View_Login extends Base_View_Base
{

	public function loginRequired()
	{
		return false;
	}

	public function checkPermission(Core_Request $request)
	{
		return true;
	}

	public function process(Core_Request $request)
	{
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('Login.tpl', $module);
	}
}
