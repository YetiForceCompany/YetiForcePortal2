<?php
/**
 * Base controller class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace App\Controller;

use App\Request;

abstract class Base
{
	public function __construct()
	{
		self::setHeaders();
	}

	public function setHeaders()
	{
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		if ((!empty($_SERVER['HTTPS']) && 'off' != strtolower($_SERVER['HTTPS'])) || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' == strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']))) {
			header('Pragma: private');
			header('Cache-Control: private, must-revalidate');
		} else {
			header('Cache-Control: private, no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}
	}

	public function loginRequired()
	{
		return true;
	}

	/**
	 * Main action.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function process(Request $request);

	/**
	 * Validates request. Checks type of request.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function validateRequest(Request $request);

	/**
	 * Action invoke before process.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function preProcess(Request $request);

	/**
	 * Action invoke after process.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function postProcess(Request $request);

	/**
	 * Action invoke before process for AJAX.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function preProcessAjax(Request $request);

	/**
	 * Action invoke after process for AJAX.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	abstract public function postProcessAjax(Request $request);
}
