<?php
/* +*******************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ****************************************************************************** */

class CSRFConfig
{
	/**
	 * Specific custom config startup for CSRF.
	 */
	public static function startup()
	{
		//Override the default expire time of token
		\CsrfMagic\Csrf::$expires = 259200;
		\CsrfMagic\Csrf::$callback = function ($tokens) {
			throw new \App\Exception\BadRequest('Invalid request - Response For Illegal Access');
		};
		$js = YF_ROOT_WWW . 'vendor/yetiforce/csrf-magic/src/Csrf.min.js';
		\CsrfMagic\Csrf::$dirSecret = __DIR__;
		\CsrfMagic\Csrf::$rewriteJs = $js;

		/* 		  if an ajax request initiated, then if php serves content with <html> tags
		 * as a response, then unnecessarily we are injecting csrf magic javascipt
		 * in the response html at <head> and <body> using csrf_ob_handler().
		 * So, to overwride above rewriting we need following config.
		 */
		if (static::isAjax()) {
			\CsrfMagic\Csrf::$frameBreaker = false;
			\CsrfMagic\Csrf::$rewriteJs = null;
		}
	}

	public static function isAjax()
	{
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}

		return false;
	}
}
