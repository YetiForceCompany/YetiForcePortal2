<?php
/**
 * CSRF config file.
 *
 * @package Config
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
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
			throw new \App\Exceptions\BadRequest('Invalid request - Response For Illegal Access');
		};
		$js = PUBLIC_DIRECTORY . 'vendor/yetiforce/csrf-magic/src/Csrf.min.js';
		\CsrfMagic\Csrf::$dirSecret = __DIR__;
		\CsrfMagic\Csrf::$rewriteJs = $js;
		\CsrfMagic\Csrf::$cspToken = \App\Session::get('CSP_TOKEN');

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
