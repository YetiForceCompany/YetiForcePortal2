<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): YetiForce.com
 ************************************************************************************/

class Core_Request {
	// Datastore
	private $valuemap;
	private $defaultmap = array();

	/**
	 * Default constructor
	 */
	function __construct($values, $stripifgpc=true) {
		$this->valuemap = $values;
		if ($stripifgpc && !empty($this->valuemap) && get_magic_quotes_gpc()) {
			$this->valuemap = $this->stripslashes_recursive($this->valuemap);
		}
	}

	/**
	 * Strip the slashes recursively on the values.
	 */
	function stripslashes_recursive($value) {
		$value = is_array($value) ? array_map(array($this, 'stripslashes_recursive'), $value) : stripslashes($value);
		return $value;
	}

	/**
	 * Get key value (otherwise default value)
	 */
	function get($key, $defvalue = '') {
		$value = $defvalue;
		if(isset($this->valuemap[$key])) {
			$value = $this->valuemap[$key];
		}
		if($value === '' && isset($this->defaultmap[$key])) {
			$value = $this->defaultmap[$key];
		}

		$isJSON = false;
		if (is_string($value)) {
			// NOTE: Zend_Json or json_decode gets confused with big-integers (when passed as string)
			// and convert them to ugly exponential format - to overcome this we are performin a pre-check
			if (strpos($value, "[") === 0 || strpos($value, "{") === 0) {
				$isJSON = true;
			}
		}
		if($isJSON) {
			$oldValue = Core_Json::$useBuiltinEncoderDecoder;
			Core_Json::$useBuiltinEncoderDecoder = false;
			$decodeValue = Core_Json::decode($value);
			if(isset($decodeValue)) {
				$value = $decodeValue;
			}
			Core_Json::$useBuiltinEncoderDecoder  = $oldValue;
		}

        //Handled for null because vtlib_purify returns empty string
        if(!empty($value)){
            //$value = vtlib_purify($value);
        }
		return $value;
	}

	/**
	 * Get data map
	 */
	function getAll() {
		return $this->valuemap;
	}

	/**
	 * Check for existence of key
	 */
	function has($key) {
		return isset($this->valuemap[$key]);
	}

	/**
	 * Is the value (linked to key) empty?
	 */
	function isEmpty($key) {
		$value = $this->get($key);
		return empty($value);
	}

	/**
	 * Set the value for key
	 */
	function set($key, $newvalue) {
		$this->valuemap[$key]= $newvalue;
	}

	/**
	 * Set default value for key
	 */
	function setDefault($key, $defvalue) {
		$this->defaultmap[$key] = $defvalue;
	}

	/**
	 * Shorthand function to get value for (key=mode)
	 */
	function getMode() {
		return $this->get('mode');
	}

	function getModule() {
		return $this->get('module');
	}

	function isAjax() {
		if(!empty($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == true) {
			return true;
		} elseif(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}
		return false;
	}
	
}
