<?php
/**
 * User action login class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Install\Action;

use App\Purifier;
use App\Response;

class Install extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function loginRequired(): bool
	{
		return false;
	}

	/** {@inheritdoc} */
	public function checkPermission(): bool
	{
		if (\YF\Modules\Install\Model\Install::isInstalled()) {
			throw new AppException('ERR_SYSTEM_HAS_BEEN_INSTALLED', 500);
		}
		return true;
	}

	/** {@inheritdoc} */
	public function process()
	{
		try {
			$response = new Response();
			$install = \YF\Modules\Install\Model\Install::getInstance($this->request->getModule());
			\Conf\Config::$apiKey = $this->request->getByType('apiKey', Purifier::TEXT);
			\Conf\Config::$crmUrl = $this->request->getByType('crmUrl', Purifier::TEXT);
			\Conf\Config::$serverName = $this->request->getByType('serverName', Purifier::TEXT);
			\Conf\Config::$serverPass = $this->request->getByType('serverPass', Purifier::TEXT);
			if ($install->check()) {
				$install->save($this->request);
				$result = ['url' => \App\Config::get('portalUrl')];
			} else {
				$result = ['error' => \App\Language::translate('LBL_WRONG_PROPERTIES', 'Install')];
			}
		} catch (\Throwable $ex) {
			$result = ['error' => $ex->getMessage()];
		}
		$response->setResult($result);
		$response->emit();
	}
}
