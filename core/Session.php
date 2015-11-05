<?php

/**
 * Sesion class
 * @package YetiForce.Core
 * @license licenses/License.html
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
namespace Core;

class Session
{
	/**
	 * 
	 * @param string $key Key in table
	 * @return Value for the key
	 */
	static public function get($key){
		return $_SESSION[$key];
	}
	/**
	 * 
	 * @param string $key Key in table
	 * @return boolean if key is definied - return true
	 */
	static public function has($key){
		return isset($_SESSION[$key]);
	}
	/**
	 * 
	 * @param $key Key in table 
	 * @param $value Value for the key
	 */
	static public function set($key, $value){
		$_SESSION[$key] = $value;
	}
	
}
