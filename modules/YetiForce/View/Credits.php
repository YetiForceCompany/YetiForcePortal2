<?php

/**
 * Credits view file.
 *
 * @copyright YetiForce Sp. z o.o
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author  Arkadiusz Sołek <a.solek@yetiforce.com>
 */

namespace YF\Modules\YetiForce\View;

/**
 * Show credits and licenses class.
 */
class Credits extends \App\Controller\View
{
	
	/** {@inheritdoc} */
	public function checkPermission(): bool
	{
		return true;
	}

	/** {@inheritdoc} */
	protected function getTitle(): string
	{
		return \App\Language::translate('LBL_VIEW_CREDITS', $this->request->getModule());
	}

	/** {@inheritdoc} */
	public function process(): void
	{
		$qualifiedModuleName = $this->request->getModule(false);
		$this->viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$this->viewer->view('Credits.tpl', $qualifiedModuleName);
	}
}
