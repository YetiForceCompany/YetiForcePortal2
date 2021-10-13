<?php
/**
 * User preferences file.
 *
 * @package Action
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Adrian Kon <a.kon@yetiforce.com>
 */

namespace YF\Modules\Users\Action;

/**
 * User preferences action class.
 */
class UserPreferences extends \App\Controller\Action
{
	/** {@inheritdoc} */
	public function checkPermission(): void
	{
	}

	/** {@inheritdoc} */
	public function process()
	{
		if ($this->request->has('userPreferences')) {
			$userPreferences = $this->request->getArray('userPreferences');
			foreach ($userPreferences as $preferenceName => $preferenceValue) {
				\App\Session::set($preferenceName, $preferenceValue);
			}
			$api = \App\Api::getInstance();
			$result = $api->call('Users/Preferences/', $userPreferences, 'put');
		}
		$response = new \App\Response();
		$response->setResult($result);
		$response->emit();
	}
}
