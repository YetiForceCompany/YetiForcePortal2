<?php

class Core_User {
	protected static $user = false;
	
	function getUser() {
		if (!self::$user) {
			self::$user = $_SESSION['user'];
		}
		return self::$user;
	}
	
	function setUser($user) {
		self::$user = $user;
	}

	protected function checkLogin(Vtiger_Request $request) {
		if (!$this->hasLogin()) {
			header('Location: index.php');
			throw new AppException('Login is required');
		}
	}
	
}
