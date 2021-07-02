<?php
/**
 * User action logout file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

/**
 * User action logout class.
 */
class Logout extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/** {@inheritdoc} */
	public function process()
	{
		\App\Api::getInstance()->call('Users/Logout', [], 'put');
		session_destroy();
		header('Location: ' . \App\Config::$portalUrl);
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$this->request->validateReadAccess();
	}
}
