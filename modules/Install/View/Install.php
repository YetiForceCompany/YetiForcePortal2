<?php
/**
 * Install view class.
 *
 * @copyright YetiForce Sp. z o.o.
 * @license   YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace YF\Modules\Install\View;

use App\AppException;
use App\Purifier;
use App\Request;

class Install extends \App\Controller\View
{
	use \App\Controller\ExposeMethodTrait;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->exposeMethod('step1');
		$this->exposeMethod('step2');
	}

	public function loginRequired(): bool
	{
		return false;
	}

	public function checkPermission()
	{
		if (\YF\Modules\Install\Model\Install::isInstalled()) {
			throw new AppException('ERR_SYSTEM_HAS_BEEN_INSTALLED', 500);
		}
		return true;
	}

	public function preProcess($display = true)
	{
		$module = $this->request->getModule();
		$this->setLanguage();
		parent::preProcess(false);
		$this->viewer->view('InstallPreProcess.tpl', $module);
	}

	public function process()
	{
		$mode = $this->request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			return $this->{$mode}();
		}
		$this->step1();
	}

	public function step1()
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallStep1.tpl', $module);
	}

	public function step2()
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallStep2.tpl', $module);
	}

	public function postProcess($display = true)
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallPostProcess.tpl', $module);
		parent::postProcess($display);
	}

	public function setLanguage()
	{
		if (!$this->request->isEmpty('lang')) {
			$userInstance = \App\User::getUser();
			$userInstance->set('language', $this->request->getByType('lang', Purifier::STANDARD));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPageTitle(): string
	{
		return \App\Language::translate('LBL_INSTALLATION_WIZARD', $this->moduleName);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateRequest()
	{
		$mode = $this->request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			if ($mode === 'step1') {
				$this->request->validateReadAccess();
			} else {
				$this->request->validateWriteAccess();
			}
		}
	}
}
