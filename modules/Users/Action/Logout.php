<?php

namespace YF\Modules\Users\Action;

/**
 * User action logout class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Logout extends \App\Controller\Action
{
	public function process(\App\Request $request)
	{
		$response = \App\Api::getInstance()->call('Users/Logout', [], 'put');
		session_destroy();
		header('Location: ' . \App\Config::$portalUrl);
	}
}
