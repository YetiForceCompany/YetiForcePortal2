<?php

class Core_User
{

	protected static $user = false;

	public static function getUser()
	{
		if (!self::$user && array_key_exists('user', $_SESSION)) {
			self::$user = (object) $_SESSION['user'];
		}
		return self::$user;
	}

	public function setUser($user)
	{
		self::$user = $user;
	}

	public function checkLogin(Core_Request $request)
	{
		if (!self::hasLogin()) {
			header('Location: index.php');
			throw new AppException('Login is required');
		}
	}

	public static function hasLogin()
	{
		if (array_key_exists('user', $_SESSION)) {
			return true;
		}
		return false;
	}
}
