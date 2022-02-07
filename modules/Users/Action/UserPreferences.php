<?php
/**
 * User preferences file.
 *
 * @package Action
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
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
		$key = $this->request->getByType('key', \App\Purifier::ALNUM_EXTENDED);
		if (!isset(\Conf\Config::$userPreferences[$key])) {
			throw new \App\Exceptions\NoPermitted('Not allowed parameter');
		}
		switch ($key) {
			case 'menuPin':
				$value = $this->request->getInteger('value');
				break;
			default:
				$value = $this->request->getByType('value', \App\Purifier::ALNUM_EXTENDED);
				break;
		}
		\App\Session::set($key, $value);
		try {
			$result = \App\Api::getInstance()
				->call('Users/Preferences/', [$key => $value], 'put');
		} catch (\Throwable $th) {
			$result = $th->getMessage();
		}
		$response = new \App\Response();
		$response->setResult($result);
		$response->emit();
	}
}
