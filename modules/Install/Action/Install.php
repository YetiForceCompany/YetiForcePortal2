<?php
/**
 * User action login class.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
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
	public function checkPermission(): void
	{
		if (\YF\Modules\Install\Model\Install::isInstalled()) {
			throw new \App\Exceptions\AppException('ERR_SYSTEM_HAS_BEEN_INSTALLED', 500);
		}
	}

	/** {@inheritdoc} */
	public function process()
	{
		try {
			$response = new Response();
			\Conf\Config::$apiKey = $this->request->getByType('apiKey', Purifier::TEXT);
			\Conf\Config::$apiUrl = $this->request->getByType('apiUrl', Purifier::TEXT);
			\Conf\Config::$serverName = $this->request->getByType('serverName', Purifier::TEXT);
			\Conf\Config::$serverPass = $this->request->getByType('serverPass', Purifier::TEXT);
			if (empty(\Conf\Config::$apiKey) || empty(\Conf\Config::$apiUrl) || empty(\Conf\Config::$serverName) || empty(\Conf\Config::$serverPass)) {
				throw new \App\Exceptions\AppException('ERR_NOT_ENTERED_REQUIRED_DATA', 500);
			}
			$install = \YF\Modules\Install\Model\Install::getInstance($this->request->getModule());
			if ($install->check()) {
				$install->save($this->request);
				$result = ['url' => \App\Config::get('portalUrl')];
			} else {
				$result = ['error' => \App\Language::translate('LBL_WRONG_PROPERTIES', 'Install')];
			}
		} catch (\Throwable $ex) {
			$result = ['error' => \App\Language::translate($ex->getMessage(), 'Install')];
		}
		$response->setResult($result);
		$response->emit();
	}
}
