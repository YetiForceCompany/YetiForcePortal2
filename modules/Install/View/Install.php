<?php
/**
 * Install view file.
 *
 * @package View
 *
 * @copyright YetiForce S.A.
 * @license   YetiForce Public License 5.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author    Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */

namespace YF\Modules\Install\View;

use App\Purifier;
use App\Request;

/**
 * Install view  class.
 */
class Install extends \App\Controller\View
{
	use \App\Controller\ExposeMethodTrait;

	/** {@inheritdoc} */
	public function __construct(Request $request)
	{
		$this->setLanguage($request);
		parent::__construct($request);
		$this->exposeMethod('step1');
		$this->exposeMethod('step2');
	}

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
	public function preProcess($display = true): void
	{
		parent::preProcess(false);
		if ($display) {
			$this->preProcessDisplay();
		}
	}

	/** {@inheritdoc}  */
	protected function preProcessTplName(): string
	{
		return 'InstallPreProcess.tpl';
	}

	/** {@inheritdoc} */
	public function process()
	{
		$mode = $this->request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			return $this->{$mode}();
		}
		$this->step1();
	}

	/**
	 * Step 1.
	 *
	 * @return void
	 */
	public function step1(): void
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallStep1.tpl', $module);
	}

	public function step2(): void
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallStep2.tpl', $module);
	}

	/** {@inheritdoc} */
	public function postProcess($display = true): void
	{
		$module = $this->request->getModule();
		$this->viewer->view('InstallPostProcess.tpl', $module);
		parent::postProcess($display);
	}

	/**
	 * Set user language.
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function setLanguage(Request $request)
	{
		if (!$request->isEmpty('lang')) {
			$userInstance = \App\User::getUser();
			$userInstance->set('language', $request->getByType('lang', Purifier::STANDARD));
		}
	}

	/** {@inheritdoc} */
	public function getPageTitle(): string
	{
		return \App\Language::translate('LBL_INSTALLATION_WIZARD', $this->moduleName);
	}

	/** {@inheritdoc} */
	public function validateRequest()
	{
		$mode = $this->request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			$this->request->validateWriteAccess();
		}
	}
}
