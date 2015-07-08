<?php

class Users_Action_Login extends Base_Action_Base
{
	public function loginRequired()
	{
		return false;
	}
	
	public function process(Core_Request $request)
	{
		$email = $request->get('email');
		$password = $request->get('password');
		$response = Core_User::doLogin($email, $password);
		if($response){
			
		}
	}
}
