<?php
/**
 * User action login class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Install\Action;

class Install extends \App\Controller\Action
{
	/**
	 * {@inheritdoc}
	 */
	public function loginRequired(): bool
	{
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function checkPermission(): bool
	{
		if (\YF\Modules\Install\Model\Install::isInstalled()) {
			throw new AppException('ERR_SYSTEM_HAS_BEEN_INSTALLED', 500);
		}
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function process()
	{
		$install = \YF\Modules\Install\Model\Install::getInstance($this->request->getModule());
		$install->save($this->request);
	}
}
